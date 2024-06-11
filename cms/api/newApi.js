const fs = require('fs');
const path = require('path');
const xlsx = require('xlsx');
const xml2js = require('xml2js');

// Paths
const excelFilePath = 'rules_template-2.xlsx';
const previousStateFilePath = 'sample.json';
const xmlFilePath = 'ruleSets_rs.xml';
const updatedXmlFilePath = 'updated_rules.xml';

// Function to read the Excel file
function readExcelFile(filePath) {
    const wb = xlsx.readFile(filePath);
    const ws = wb.Sheets[wb.SheetNames[0]]; // Assuming the first sheet contains the rules
    return xlsx.utils.sheet_to_json(ws, { header: 1 });
}

// Function to load the previous state from a JSON file
function loadPreviousState(filePath) {
    if (fs.existsSync(filePath)) {
        return JSON.parse(fs.readFileSync(filePath, 'utf8'));
    }
    return null;
}

// Function to save the current state to a JSON file
function saveCurrentState(data, filePath) {
    fs.writeFileSync(filePath, JSON.stringify(data, null, 2), 'utf8');
}

// Function to detect changes between two states
function detectChanges(previousState, currentState) {
    const changes = [];
    const previousStateMap = new Map(previousState.map(row => [row[0], row[1]]));
    const currentStateMap = new Map(currentState.map(row => [row[0], row[1]]));

    // Detect changes and additions
    for (const [rule, option] of currentStateMap) {
        if (!previousStateMap.has(rule) || previousStateMap.get(rule) !== option) {
            changes.push({ rule, option });
        }
    }

    // Detect deletions
    for (const [rule] of previousStateMap) {
        if (!currentStateMap.has(rule)) {
            changes.push({ rule, option: null });
        }
    }

    return changes;
}

// Function to update the XML file based on detected changes
function updateXmlFile(changes, filePath, updatedFilePath) {
    fs.readFile(filePath, 'utf8', (err, data) => {
        if (err) throw err;

        xml2js.parseString(data, (err, result) => {
            if (err) throw err;

            // Apply changes to the XML structure
            for (const change of changes) {
                const { rule, option } = change;

                // Find the styleName with the corresponding rule ID
                const styleName = result.styles.styleName.find(sn => sn.$.id === rule);
                if (styleName) {
                    if (option) {
                        // Update the styleName with the new option
                        styleName.$.name = option;
                    } else {
                        // Remove the styleName if the option is null
                        const index = result.styles.styleName.indexOf(styleName);
                        result.styles.styleName.splice(index, 1);
                    }
                } else if (option) {
                    // Add a new styleName if it does not exist
                    result.styles.styleName.push({ $: { id: rule, name: option } });
                }
            }

            // Convert the updated JSON back to XML
            const builder = new xml2js.Builder();
            const updatedXml = builder.buildObject(result);

            // Save the updated XML to a file
            fs.writeFile(updatedFilePath, updatedXml, 'utf8', (err) => {
                if (err) throw err;
                console.log('Updated XML file saved.');
            });
        });
    });
}

// Main script logic
const currentState = readExcelFile(excelFilePath);
const previousState = loadPreviousState(previousStateFilePath) || [];

const changes = detectChanges(previousState, currentState);
if (changes.length > 0) {
    console.log('Detected changes:', changes);
    updateXmlFile(changes, xmlFilePath, updatedXmlFilePath);
    saveCurrentState(currentState, previousStateFilePath);
} else {
    console.log('No changes detected.');
}
