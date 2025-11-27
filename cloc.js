const path = require('node:path');
const fs = require('node:fs');

function readFiles(start = './', suffix = '.php') {
	start = path.join(__dirname, start);
	const dir = fs.readdirSync(start, {recursive: true});
	const phpFiles = [];

	for (const item of dir) {
		if (item.endsWith(suffix))
			phpFiles.push(path.join(start, item));
	}

	return phpFiles;
}

const files = readFiles();

let charCount = 0;
let lineCount = 0;
let fileCount = 0;

for (const file of files) {
	const content = fs.readFileSync(file, 'utf-8');

	charCount += content.length;
	lineCount += content.split('\n').length;
	fileCount++;
}

console.log(`Char Count: ${charCount}`);
console.log(`Line Count: ${lineCount}`);
console.log(`File Count: ${fileCount}`);
