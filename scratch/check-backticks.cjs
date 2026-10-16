const fs = require('fs');
const content = fs.readFileSync('resources/views/admin/portal-manager.blade.php', 'utf8');
const lines = content.split('\n');

// Find the second <script> block (the big one)
let scriptStart = -1;
let scriptEnd = -1;
for (let i = 0; i < lines.length; i++) {
    if (lines[i].trim() === '<script>' && scriptStart === -1 && i > 30) {
        scriptStart = i + 1;
        continue;
    }
    if (scriptStart !== -1 && lines[i].includes('</script>') && scriptEnd === -1) {
        scriptEnd = i;
    }
}

console.log(`Script block: line ${scriptStart} to ${scriptEnd} (${scriptEnd - scriptStart} lines)`);

// Check backtick balance within script
const scriptLines = lines.slice(scriptStart, scriptEnd);
let scriptCode = scriptLines.join('\n');

// Count unescaped backticks (outside of other strings)
let backtickCount = 0;
let inSingleQuote = false;
let inDoubleQuote = false;
let backtickDepth = 0;
for (let i = 0; i < scriptCode.length; i++) {
    const ch = scriptCode[i];
    const prev = scriptCode[i - 1];
    if (ch === "'" && !inDoubleQuote && backtickDepth === 0 && prev !== '\\') inSingleQuote = !inSingleQuote;
    if (ch === '"' && !inSingleQuote && backtickDepth === 0 && prev !== '\\') inDoubleQuote = !inDoubleQuote;
    if (ch === '`' && !inSingleQuote && !inDoubleQuote) {
        if (backtickDepth === 0) {
            backtickDepth++;
            backtickCount++;
        } else {
            backtickDepth--;
        }
    }
}
console.log(`Total backtick-literal opens: ${backtickCount}, final backtick depth: ${backtickDepth}`);
if (backtickDepth !== 0) {
    console.error('WARNING: Unbalanced backticks in script!');
}

// Also check for any </script> within the script content
const scriptCloseMatches = scriptCode.match(/<\/script>/gi);
if (scriptCloseMatches) {
    console.error(`WARNING: Found ${scriptCloseMatches.length} </script> inside script block! This will break the page.`);
} else {
    console.log('No </script> found inside script block. OK.');
}
