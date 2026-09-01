#!/usr/bin/env node

/**
 * Cloudflare D1 & R2 OS-Agnostic Setup Script
 * Supports Windows, Linux, and macOS.
 *
 * Usage:
 *   node scripts/setup-cloudflare.mjs [options]
 *   npm run setup:cloudflare     (runs interactive or create mode)
 *   npm run configure:cloudflare (runs connect to existing remote mode)
 */

import * as readline from 'node:readline/promises';
import { stdin as input, stdout as output } from 'node:process';
import * as fs from 'node:fs';
import * as path from 'node:path';
import { fileURLToPath } from 'node:url';
import { spawnSync, execSync } from 'node:child_process';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const projectRoot = path.resolve(__dirname, '..');
const envPath = path.join(projectRoot, '.env');
const envExamplePath = path.join(projectRoot, '.env.example');

// ANSI Colors for cross-platform output
const ansi = {
  reset: '\x1b[0m',
  bright: '\x1b[1m',
  dim: '\x1b[2m',
  green: '\x1b[32m',
  yellow: '\x1b[33m',
  blue: '\x1b[34m',
  magenta: '\x1b[35m',
  cyan: '\x1b[36m',
  red: '\x1b[31m',
};

const c = {
  info: (msg) => `${ansi.cyan}ℹ ${msg}${ansi.reset}`,
  success: (msg) => `${ansi.green}✔ ${msg}${ansi.reset}`,
  warn: (msg) => `${ansi.yellow}⚠ ${msg}${ansi.reset}`,
  error: (msg) => `${ansi.red}✖ ${msg}${ansi.reset}`,
  title: (msg) => `${ansi.bright}${ansi.magenta}${msg}${ansi.reset}`,
  bold: (msg) => `${ansi.bright}${msg}${ansi.reset}`,
  dim: (msg) => `${ansi.dim}${msg}${ansi.reset}`,
  green: (msg) => `${ansi.green}${msg}${ansi.reset}`,
  cyan: (msg) => `${ansi.cyan}${msg}${ansi.reset}`,
  yellow: (msg) => `${ansi.yellow}${msg}${ansi.reset}`,
};

const colors = {
  ...ansi,
  bold: c.bold,
  dim: c.dim,
};

function parseArgs() {
  const args = process.argv.slice(2);
  const options = {
    help: false,
    create: false,
    connect: false,
    syncStorage: false,
    test: false,
    yes: false,
    accountId: '',
    apiToken: '',
    dbName: '',
    dbId: '',
    bucketName: '',
    privateBucketName: '',
    r2Key: '',
    r2Secret: '',
    r2Url: '',
  };

  for (let i = 0; i < args.length; i++) {
    const arg = args[i];
    if (arg === '--help' || arg === '-h') options.help = true;
    else if (arg === '--create' || arg === '-c') options.create = true;
    else if (arg === '--connect' || arg === '--existing' || arg === '-e') options.connect = true;
    else if (arg === '--sync-storage' || arg === '-s') options.syncStorage = true;
    else if (arg === '--test' || arg === '-t') options.test = true;
    else if (arg === '--yes' || arg === '-y') options.yes = true;
    else if (arg.startsWith('--account-id=')) options.accountId = arg.split('=')[1];
    else if (arg.startsWith('--api-token=')) options.apiToken = arg.split('=')[1];
    else if (arg.startsWith('--db-name=')) options.dbName = arg.split('=')[1];
    else if (arg.startsWith('--db-id=')) options.dbId = arg.split('=')[1];
    else if (arg.startsWith('--bucket-name=')) options.bucketName = arg.split('=')[1];
    else if (arg.startsWith('--private-bucket-name=')) options.privateBucketName = arg.split('=')[1];
    else if (arg.startsWith('--r2-key=')) options.r2Key = arg.split('=')[1];
    else if (arg.startsWith('--r2-secret=')) options.r2Secret = arg.split('=')[1];
    else if (arg.startsWith('--r2-url=')) options.r2Url = arg.split('=')[1];
  }

  return options;
}

function showHelp() {
  console.log(`
${c.title('Cloudflare D1 & R2 OS-Agnostic Setup Tool')}

${c.bold('USAGE:')}
  node scripts/setup-cloudflare.mjs [options]
  npm run setup:cloudflare
  npm run configure:cloudflare

${c.bold('OPTIONS:')}
  --help, -h                  Show this help message
  --create, -c                Provision brand new D1 Database and R2 Buckets (Public & Private)
  --connect, -e               Connect to already existing remote D1 and R2 resources
  --sync-storage, -s          Sync local storage files to Cloudflare R2
  --test, -t                  Test Cloudflare D1 & R2 connections
  --yes, -y                   Automatic yes to confirmation prompts

${c.bold('DIRECT PARAMETERS (for CI/CD or non-interactive use):')}
  --account-id=<id>           Cloudflare Account ID
  --api-token=<token>         Cloudflare D1 API Token (Bearer Token)
  --db-name=<name>            D1 Database Name (for creation)
  --db-id=<uuid>              D1 Database ID / UUID (for connect mode)
  --bucket-name=<name>        Public R2 Bucket Name (for news, activities, media)
  --private-bucket-name=<name> Private R2 Bucket Name (for protected downloads)
  --r2-key=<key>              Cloudflare R2 Access Key ID
  --r2-secret=<secret>        Cloudflare R2 Secret Access Key
  --r2-url=<url>              Public URL for public R2 bucket (custom domain or .r2.dev)
`);
}

function runCommand(command, args = [], options = {}) {
  let cmdLine = command;
  if (Array.isArray(args) && args.length > 0) {
    const formattedArgs = args.map((arg) => {
      const s = String(arg);
      if (s.includes(' ') || s.includes('"') || s.includes('&') || s.includes('|') || s.includes('<') || s.includes('>')) {
        return `"${s.replace(/"/g, '\\"')}"`;
      }
      return s;
    });
    cmdLine = `${command} ${formattedArgs.join(' ')}`;
  }

  const result = spawnSync(cmdLine, {
    cwd: projectRoot,
    shell: true,
    encoding: 'utf-8',
    stdio: options.stdio || 'pipe',
    env: { ...process.env, ...options.env },
  });

  return result;
}

function readEnv() {
  if (!fs.existsSync(envPath)) {
    if (fs.existsSync(envExamplePath)) {
      fs.copyFileSync(envExamplePath, envPath);
      console.log(c.info('Created .env from .env.example'));
    } else {
      fs.writeFileSync(envPath, '');
    }
  }

  const content = fs.readFileSync(envPath, 'utf-8');
  const vars = {};
  for (const line of content.split('\n')) {
    const trimmed = line.trim();
    if (trimmed && !trimmed.startsWith('#')) {
      const match = trimmed.match(/^([^=]+)=(.*)$/);
      if (match) {
        let val = match[2].trim();
        if ((val.startsWith('"') && val.endsWith('"')) || (val.startsWith("'") && val.endsWith("'"))) {
          val = val.slice(1, -1);
        }
        vars[match[1].trim()] = val;
      }
    }
  }
  return { content, vars };
}

function updateEnv(updates) {
  const { content } = readEnv();
  let lines = content.split('\n');
  const appliedKeys = new Set();

  lines = lines.map((line) => {
    const trimmed = line.trim();
    if (!trimmed || trimmed.startsWith('#')) return line;
    const match = trimmed.match(/^([^=]+)=(.*)$/);
    if (match) {
      const key = match[1].trim();
      if (key in updates) {
        appliedKeys.add(key);
        const val = updates[key];
        return `${key}=${val.includes(' ') || val.includes('$') ? `"${val}"` : val}`;
      }
    }
    return line;
  });

  // Append any keys that weren't present in the file
  const remainingKeys = Object.keys(updates).filter((k) => !appliedKeys.has(k));
  if (remainingKeys.length > 0) {
    if (lines.length > 0 && lines[lines.length - 1].trim() !== '') {
      lines.push('');
    }
    lines.push('# Cloudflare D1 & R2 Configured Settings');
    for (const key of remainingKeys) {
      const val = updates[key];
      lines.push(`${key}=${val.includes(' ') || val.includes('$') ? `"${val}"` : val}`);
    }
  }

  fs.writeFileSync(envPath, lines.join('\n'));
  console.log(c.success('.env updated successfully with Cloudflare settings!'));
}

async function verifyWrangler(rl) {
  console.log(c.info('Checking Cloudflare Wrangler CLI...'));
  const check = runCommand('npx', ['wrangler', '--version']);
  if (check.status === 0 && check.stdout) {
    const versionMatch = check.stdout.match(/\d+\.\d+\.\d+/);
    const ver = versionMatch ? versionMatch[0] : check.stdout.trim();
    console.log(c.success(`Cloudflare Wrangler CLI detected (v${ver})`));
  } else {
    console.log(c.warn('Wrangler is not yet installed in devDependencies.'));
    const install = await rl.question('Would you like to install wrangler now? (Y/n): ');
    if (install.toLowerCase() !== 'n') {
      console.log(c.info('Installing wrangler...'));
      runCommand('npm', ['install', '--save-dev', 'wrangler'], { stdio: 'inherit' });
    }
  }

  // Check login state via `wrangler whoami`
  console.log(c.info('Checking Cloudflare authentication status...'));
  let whoami = runCommand('npx', ['wrangler', 'whoami']);
  let output = (whoami.stdout || '') + (whoami.stderr || '');

  if (whoami.status === 0 && !output.includes('You are not logged in')) {
    const emailMatch = output.match(/associated with the email ([^\s,]+?)\.?(\s|$)/i) || output.match(/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/);
    const emailStr = emailMatch ? ` as ${c.bold(emailMatch[1] || emailMatch[0])}` : '';
    console.log(c.success(`Logged in to Cloudflare Wrangler${emailStr}`));
  } else {
    console.log(c.warn('You are currently not logged in to Cloudflare Wrangler.'));
    const doLogin = await rl.question('Open browser to login via Cloudflare Wrangler now? (Y/n): ');
    if (doLogin.toLowerCase() !== 'n') {
      console.log(c.info('Running `npx wrangler login`...'));
      runCommand('npx', ['wrangler', 'login'], { stdio: 'inherit' });
      whoami = runCommand('npx', ['wrangler', 'whoami']);
      output = (whoami.stdout || '') + (whoami.stderr || '');
    }
  }

  // Extract account id if present (format: │ Account ID │ <hex-id> │)
  let detectedAccountId = '';
  const match = output.match(/[0-9a-fA-F]{32}/);
  if (match) {
    detectedAccountId = match[0];
    console.log(c.success(`Detected Cloudflare Account ID: ${c.bold(detectedAccountId)}`));
  }

  return detectedAccountId;
}

async function createMode(rl, initialAccountId, cliOptions) {
  console.log(`\n${c.title('=== Mode: Create New Cloudflare Resources ===')}\n`);

  let accountId = cliOptions.accountId || initialAccountId;
  if (!accountId) {
    accountId = (await rl.question(`Enter your Cloudflare Account ID: `)).trim();
  } else {
    const confirm = await rl.question(`Use detected Cloudflare Account ID (${c.bold(accountId)})? (Y/n): `);
    if (confirm.toLowerCase() === 'n') {
      accountId = (await rl.question(`Enter your Cloudflare Account ID: `)).trim();
    }
  }

  // 1. D1 Database Creation
  let dbName = cliOptions.dbName;
  if (!dbName) {
    dbName = (await rl.question(`Enter new D1 database name (default: ${c.green('spprototype-d1')}): `)).trim() || 'spprototype-d1';
  }

  console.log(c.info(`Creating Cloudflare D1 database: ${dbName}...`));
  const d1Res = runCommand('npx', ['wrangler', 'd1', 'create', dbName]);
  const d1Out = (d1Res.stdout || '') + (d1Res.stderr || '');
  console.log(d1Out);

  let d1Id = '';
  const uuidMatch = d1Out.match(/([0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12})/i);
  if (uuidMatch) {
    d1Id = uuidMatch[1];
    console.log(c.success(`D1 Database created with UUID: ${c.bold(d1Id)}`));
  } else {
    d1Id = (await rl.question(`Could not auto-detect UUID. Enter D1 Database ID: `)).trim();
  }

  // 2. R2 Public Bucket Creation
  let bucketName = cliOptions.bucketName;
  if (!bucketName) {
    bucketName = (await rl.question(`Enter public R2 bucket name (default: ${c.green('spp-public')}): `)).trim() || 'spp-public';
  }

  console.log(c.info(`Creating public Cloudflare R2 bucket: ${bucketName}...`));
  const r2Res = runCommand('npx', ['wrangler', 'r2', 'bucket', 'create', bucketName]);
  console.log((r2Res.stdout || '') + (r2Res.stderr || ''));

  // 3. R2 Private Bucket Creation
  let privateBucketName = cliOptions.privateBucketName;
  if (!privateBucketName) {
    privateBucketName = (await rl.question(`Enter private R2 bucket name for protected downloads (default: ${c.green(bucketName + '-private')}): `)).trim() || `${bucketName}-private`;
  }

  console.log(c.info(`Creating private Cloudflare R2 bucket: ${privateBucketName}...`));
  const r2PrivRes = runCommand('npx', ['wrangler', 'r2', 'bucket', 'create', privateBucketName]);
  console.log((r2PrivRes.stdout || '') + (r2PrivRes.stderr || ''));

  return await collectCredentials(rl, { accountId, d1Id, bucketName, privateBucketName }, cliOptions);
}

async function connectMode(rl, initialAccountId, cliOptions) {
  console.log(`\n${c.title('=== Mode: Connect to Existing Remote Cloudflare Resources ===')}\n`);

  let accountId = cliOptions.accountId || initialAccountId;
  if (!accountId) {
    accountId = (await rl.question(`Enter your Cloudflare Account ID: `)).trim();
  } else {
    const confirm = await rl.question(`Use Cloudflare Account ID (${c.bold(accountId)})? (Y/n): `);
    if (confirm.toLowerCase() === 'n') {
      accountId = (await rl.question(`Enter your Cloudflare Account ID: `)).trim();
    }
  }

  // 1. List existing D1 databases
  console.log(c.info('Fetching existing D1 databases from Cloudflare...'));
  let d1Id = cliOptions.dbId;
  if (!d1Id) {
    const listRes = runCommand('npx', ['wrangler', 'd1', 'list', '--json']);
    let databases = [];
    try {
      if (listRes.status === 0 && listRes.stdout) {
        databases = JSON.parse(listRes.stdout.trim());
      }
    } catch {
      // Fallback
    }

    if (Array.isArray(databases) && databases.length > 0) {
      console.log(`\nFound ${databases.length} existing D1 database(s):`);
      databases.forEach((db, idx) => {
        console.log(`  [${idx + 1}] ${c.bold(db.name)} (${c.dim(db.uuid || db.id)})`);
      });
      console.log(`  [0] Enter custom Database UUID manually`);

      const choice = (await rl.question(`Select database [1-${databases.length}]: `)).trim();
      const num = parseInt(choice, 10);
      if (num >= 1 && num <= databases.length) {
        const selected = databases[num - 1];
        d1Id = selected.uuid || selected.id;
        console.log(c.success(`Selected D1 database: ${selected.name} (${d1Id})`));
      }
    }

    if (!d1Id) {
      d1Id = (await rl.question(`Enter your existing Cloudflare D1 Database UUID: `)).trim();
    }
  }

  // 2. List existing R2 buckets
  let bucketName = cliOptions.bucketName;
  let privateBucketName = cliOptions.privateBucketName;
  if (!bucketName || !privateBucketName) {
    console.log(c.info('Fetching existing R2 buckets from Cloudflare...'));
    const r2List = runCommand('npx', ['wrangler', 'r2', 'bucket', 'list']);
    const r2Out = (r2List.stdout || '') + (r2List.stderr || '');

    const bucketMatches = [...r2Out.matchAll(/name:\s+([^\r\n]+)/g)].map((m) => m[1].trim());

    if (bucketMatches.length > 0) {
      console.log(`\nFound ${bucketMatches.length} existing R2 bucket(s):`);
      bucketMatches.forEach((b, idx) => {
        console.log(`  [${idx + 1}] ${c.bold(b)}`);
      });
      console.log(`  [0] Enter custom bucket name manually`);

      if (!bucketName) {
        const choice = (await rl.question(`Select public R2 bucket [1-${bucketMatches.length}]: `)).trim();
        const num = parseInt(choice, 10);
        if (num >= 1 && num <= bucketMatches.length) {
          bucketName = bucketMatches[num - 1];
          console.log(c.success(`Selected public bucket: ${bucketName}`));
        }
      }
    } else if (r2Out.trim()) {
      console.log(r2Out);
    }

    if (!bucketName) {
      bucketName = (await rl.question(`Enter your public Cloudflare R2 bucket name: `)).trim();
    }
    if (!privateBucketName) {
      privateBucketName = (await rl.question(`Enter your private Cloudflare R2 bucket name (default: ${c.green(bucketName + '-private')}): `)).trim() || `${bucketName}-private`;
    }
  }

  return await collectCredentials(rl, { accountId, d1Id, bucketName, privateBucketName }, cliOptions);
}

async function collectCredentials(rl, config, cliOptions) {
  const { vars } = readEnv();

  console.log(`\n${c.title('=== Cloudflare Secrets & Credentials Configuration ===')}\n`);

  // D1 API Token
  let d1ApiToken = cliOptions.apiToken || vars.CLOUDFLARE_D1_API_TOKEN;
  if (d1ApiToken) {
    const keep = await rl.question(`Keep existing CLOUDFLARE_D1_API_TOKEN (${c.dim(d1ApiToken.slice(0, 6) + '...' + d1ApiToken.slice(-4))})? (Y/n): `);
    if (keep.toLowerCase() === 'n') d1ApiToken = '';
  }

  if (!d1ApiToken) {
    console.log(`\n${c.info('To create a Cloudflare D1 API Token:')}`);
    console.log(`  1. Go to: ${c.cyan('https://dash.cloudflare.com/profile/api-tokens')}`);
    console.log(`  2. Click "Create Token" → Custom Token`);
    console.log(`  3. Permissions: ${c.bold('Account > D1 > Edit')} and/or ${c.bold('Account > Workers R2 Storage > Edit')}`);
    d1ApiToken = (await rl.question(`Enter Cloudflare D1 API Token: `)).trim();
  }

  // R2 S3 Access Keys
  let r2Key = cliOptions.r2Key || vars.CLOUDFLARE_R2_ACCESS_KEY_ID;
  if (r2Key) {
    const keep = await rl.question(`Keep existing CLOUDFLARE_R2_ACCESS_KEY_ID (${c.dim(r2Key.slice(0, 6) + '...')})? (Y/n): `);
    if (keep.toLowerCase() === 'n') r2Key = '';
  }

  if (!r2Key) {
    console.log(`\n${c.info('To get R2 S3-Compatible API Credentials:')}`);
    console.log(`  1. Go to: ${c.cyan(`https://dash.cloudflare.com/${config.accountId}/r2/api-tokens`)}`);
    console.log(`  2. Click "Manage R2 API Tokens" → "Create API Token" (Permissions: Object Read & Write)`);
    r2Key = (await rl.question(`Enter Cloudflare R2 Access Key ID: `)).trim();
  }

  let r2Secret = cliOptions.r2Secret || vars.CLOUDFLARE_R2_SECRET_ACCESS_KEY;
  if (r2Secret) {
    const keep = await rl.question(`Keep existing CLOUDFLARE_R2_SECRET_ACCESS_KEY (${c.dim('••••••••••••')})? (Y/n): `);
    if (keep.toLowerCase() === 'n') r2Secret = '';
  }

  if (!r2Secret) {
    r2Secret = (await rl.question(`Enter Cloudflare R2 Secret Access Key: `)).trim();
  }

  // R2 Public URL (Custom domain or pub-xxxx.r2.dev)
  let r2Url = cliOptions.r2Url || vars.CLOUDFLARE_R2_URL;
  if (!r2Url) {
    r2Url = (await rl.question(`Enter public R2 URL or Custom Domain (e.g. https://pub-xxx.r2.dev or https://cdn.domain.com, or leave blank): `)).trim();
  }

  const endpoint = `https://${config.accountId}.r2.cloudflarestorage.com`;

  const envUpdates = {
    DB_CONNECTION: 'd1',
    CLOUDFLARE_ACCOUNT_ID: config.accountId,
    CLOUDFLARE_D1_DATABASE_ID: config.d1Id,
    CLOUDFLARE_D1_API_TOKEN: d1ApiToken,
    FILESYSTEM_DISK: 'r2',
    FILESYSTEM_PRIVATE_DISK: 'r2-private',
    CLOUDFLARE_R2_ACCESS_KEY_ID: r2Key,
    CLOUDFLARE_R2_SECRET_ACCESS_KEY: r2Secret,
    CLOUDFLARE_R2_REGION: 'auto',
    CLOUDFLARE_R2_BUCKET: config.bucketName,
    CLOUDFLARE_R2_PRIVATE_BUCKET: config.privateBucketName || `${config.bucketName}-private`,
    CLOUDFLARE_R2_ENDPOINT: endpoint,
    CLOUDFLARE_R2_URL: r2Url || '',
    CLOUDFLARE_R2_USE_PATH_STYLE_ENDPOINT: 'false',
  };

  updateEnv(envUpdates);

  // Post-setup actions
  await postSetupPrompts(rl);
}

async function postSetupPrompts(rl) {
  console.log(`\n${c.title('=== Database Migrations & Verification ===')}\n`);

  // Clear config cache first
  runCommand('php', ['artisan', 'config:clear']);

  const runMigrate = await rl.question('Would you like to run database migrations against Cloudflare D1 now? (Y/n): ');
  if (runMigrate.toLowerCase() !== 'n') {
    console.log(c.info('Running `php artisan migrate --force`...'));
    const migrate = runCommand('php', ['artisan', 'migrate', '--force'], { stdio: 'inherit' });

    if (migrate.status === 0) {
      console.log(c.success('Migrations executed successfully on Cloudflare D1!'));

      const runSeed = await rl.question('Would you like to run database seeders against Cloudflare D1? (y/N): ');
      if (runSeed.toLowerCase() === 'y') {
        console.log(c.info('Running `php artisan db:seed`...'));
        runCommand('php', ['artisan', 'db:seed'], { stdio: 'inherit' });
      }
    } else {
      console.log(c.warn('Migrations encountered a note or warning. Verify database connection credentials.'));
    }
  }

  // Storage Sync
  const runSync = await rl.question('\nWould you like to sync existing local files (storage/app/public) to Cloudflare R2? (y/N): ');
  if (runSync.toLowerCase() === 'y') {
    console.log(c.info('Running `php artisan cloudflare:sync-storage`...'));
    runCommand('php', ['artisan', 'cloudflare:sync-storage'], { stdio: 'inherit' });
  }

  console.log(`\n${c.title('🎉 Cloudflare D1 & R2 Setup Complete!')}`);
  console.log(`You can run ${c.bold('php artisan cloudflare:test')} at any time to verify connectivity.`);
}

async function testConnections() {
  console.log(c.info('Testing Cloudflare D1 & R2 connections...'));
  runCommand('php', ['artisan', 'cloudflare:test'], { stdio: 'inherit' });
}

async function syncStorage() {
  console.log(c.info('Syncing storage to Cloudflare R2...'));
  runCommand('php', ['artisan', 'cloudflare:sync-storage'], { stdio: 'inherit' });
}

async function main() {
  const options = parseArgs();

  if (options.help) {
    showHelp();
    process.exit(0);
  }

  if (options.test) {
    await testConnections();
    process.exit(0);
  }

  if (options.syncStorage) {
    await syncStorage();
    process.exit(0);
  }

  const rl = readline.createInterface({ input, output });

  try {
    console.log(`\n${c.cyan('╔══════════════════════════════════════════════════════════════╗')}`);
    console.log(`${c.cyan('║            Cloudflare D1 & R2 Setup Wizard                   ║')}`);
    console.log(`${c.cyan('╚══════════════════════════════════════════════════════════════╝')}\n`);

    const initialAccountId = await verifyWrangler(rl);

    if (options.create) {
      await createMode(rl, initialAccountId, options);
    } else if (options.connect) {
      await connectMode(rl, initialAccountId, options);
    } else {
      // Interactive Menu
      console.log(`\nPlease choose an option:`);
      console.log(`  ${c.bold('1)')} Create new Cloudflare D1 Database & R2 Bucket`);
      console.log(`  ${c.bold('2)')} Connect to existing remote Cloudflare D1 & R2 resources`);
      console.log(`  ${c.bold('3)')} Sync local storage to Cloudflare R2`);
      console.log(`  ${c.bold('4)')} Test Cloudflare D1 & R2 connections`);
      console.log(`  ${c.bold('5)')} Exit\n`);

      const choice = (await rl.question(`Enter selection [1-5]: `)).trim();

      if (choice === '1') {
        await createMode(rl, initialAccountId, options);
      } else if (choice === '2') {
        await connectMode(rl, initialAccountId, options);
      } else if (choice === '3') {
        await syncStorage();
      } else if (choice === '4') {
        await testConnections();
      } else {
        console.log('Exiting.');
      }
    }
  } catch (err) {
    console.error(c.error(`Setup failed: ${err.message}`));
  } finally {
    rl.close();
  }
}

main();
