const fs = require('fs');

// const convertPhpArrayToJson = (phpArrayString) => {
//     return phpArrayString
//     .replace(/array\s*\(/g, '{')    // Replace "array(" with "{"
//     .replace(/\)/g, '}')            // Replace ")" with "}"
//     .replace(/=>/g, ':')            // Replace "=>" with ":"
//     .replace(/'/g, '"')             // Replace single quotes with double quotes
//     .replace(/;$/g, '')             // Remove the trailing semicolon
//     .replace(/(\r\n|\n|\r)/gm, '')  // Remove line breaks
//     .replace(/\s/g, "")             // Remove whitespace
//     .replace(/,(?=[^,]*$)/, '');    // Remove the last comma
// };

// const phpFileContent = fs.readFileSync('C:\\Users\\AONE MANAGEMENT\\OneDrive\\Desktop\\scExcel\\testing\\replacePattern.php', 'utf8');

// const phpArrayStart = phpFileContent.indexOf('$replacePatternArray = array(');
// const phpArrayEnd = phpFileContent.lastIndexOf(');');
// const phpArrayString = phpFileContent.substring(phpArrayStart + '$replacePatternArray = '.length, phpArrayEnd + 2);

// const jsonString = convertPhpArrayToJson(phpArrayString);

// console.log("hi");
// console.log(jsonString);

// try {
//     const jsonObject = JSON.parse(jsonString);
//     console.log(jsonObject);
// } catch (e) {
//     console.error("Error parsing JSON string:", e.message);
// }


const phpFileContent = fs.readFileSync('C:\\Users\\AONE MANAGEMENT\\OneDrive\\Desktop\\scExcel\\testing\\replacePattern.php');

function phpArrayToJsObject(phpFileContent) {
    const phpArrayPattern = /array\s*\(([^)]*)\)/g;
    const keyValuePattern = /["']?([^"'\s=>]*)["']?\s*=>\s*/;
    const singleQuotePattern = /'/g;
    const doubleQuotePattern = /"/g;
    const emptyArrayPattern = /array\(\s*\)/g;

    function parseArray(arrayString) {
        arrayString = arrayString.trim();
        if (arrayString === '') return {};

        const elements = [];
        let currentElement = '';
        let inQuotes = false;
        let quoteType = '';

        for (let i = 0; i < arrayString.length; i++) {
            const char = arrayString[i];
            if (char === ',' && !inQuotes) {
                elements.push(currentElement.trim());
                currentElement = '';
            } else {
                currentElement += char;
                if ((char === '"' || char === "'") && (i === 0 || arrayString[i - 1] !== '\\')) {
                    if (!inQuotes) {
                        inQuotes = true;
                        quoteType = char;
                    } else if (quoteType === char) {
                        inQuotes = false;
                    }
                }
            }
        }
        if (currentElement) elements.push(currentElement.trim());

        const obj = {};
        elements.forEach(element => {
            const match = element.match(keyValuePattern);
            if (match) {
                const key = match[1];
                const value = element.substring(match[0].length).trim();
                obj[key] = parseValue(value);
            }
        });

        return obj;
    }

    function parseValue(value) {
        if (value.match(phpArrayPattern)) {
            return parseArray(value.replace(phpArrayPattern, '$1'));
        } else if (value === 'true') {
            return true;
        } else if (value === 'false') {
            return false;
        } else if (value === 'null') {
            return null;
        } else if (value.match(/^\d+$/)) {
            return parseInt(value, 10);
        } else if (value.match(/^\d+\.\d+$/)) {
            return parseFloat(value);
        } else {
            return value.replace(singleQuotePattern, '"').replace(doubleQuotePattern, '\\"');
        }
    }

    const phpArrayMatch = phpFileContent.match(phpArrayPattern);
    if (phpArrayMatch) {
        const jsObject = parseArray(phpArrayMatch[0].replace(phpArrayPattern, '$1'));
        return JSON.stringify(jsObject, null, 4);
    } else {
        throw new Error('No PHP array found in the provided code.');
    }
}

const jsObject = phpArrayToJsObject(phpFileContent);
console.log(jsObject);

