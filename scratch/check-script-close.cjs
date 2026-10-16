const fs = require('fs');
const content = fs.readFileSync('resources/views/admin/portal-manager.blade.php', 'utf8');

// Check the script block more carefully for what the HTML parser would see
// The browser HTML parser terminates script tags when it sees </script (case-insensitive)
const lines = content.split('\n');
let inScript = false;
let scriptLineStart = -1;

for (let i = 0; i < lines.length; i++) {
    if (!inScript && lines[i].trim() === '<script>' && i > 30) {
        inScript = true;
        scriptLineStart = i + 1;
        continue;
    }
    if (inScript) {
        // What would the HTML parser see?
        // The HTML parser sees </script> as ending the script, even inside a JS string/template literal
        const lowerLine = lines[i].toLowerCase();
        if (lowerLine.includes('</script') && !lines[i].includes('</script>')) {
            // Partial match
        }
        if (lowerLine.includes('</script>')) {
            console.log(`Found </script> at line ${i + 1}: "${lines[i].trim()}"`);
        }
    }
}

// Now find ALL actual </script> occurrences 
const allMatches = [];
let idx = 0;
while ((idx = content.toLowerCase().indexOf('</script', idx)) !== -1) {
    // get the line number
    const before = content.substring(0, idx);
    const lineNum = before.split('\n').length;
    const lineContent = content.split('\n')[lineNum - 1];
    allMatches.push({ lineNum, lineContent: lineContent.trim().substring(0, 100) });
    idx++;
}

console.log(`Total </script occurrences: ${allMatches.length}`);
allMatches.forEach(m => console.log(`  Line ${m.lineNum}: ${m.lineContent}`));
