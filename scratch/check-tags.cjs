const fs = require('fs');

const content = fs.readFileSync('resources/views/admin/portal-manager.blade.php', 'utf8');

// Check div open and close tags
const lines = content.split('\n');
let divBalance = 0;
const stack = [];

for (let i = 0; i < lines.length; i++) {
    const line = lines[i];
    // Simple tag counter
    const openDivs = (line.match(/<div(\s|>)/gi) || []).length;
    const closeDivs = (line.match(/<\/div>/gi) || []).length;
    divBalance += openDivs - closeDivs;
    if (divBalance < 0) {
        console.log(`Div balance negative at line ${i + 1}: ${divBalance}`);
    }
}
console.log(`Final div balance at end of file: ${divBalance}`);
