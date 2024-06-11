const fs = require('fs');
const xml2js = require('xml2js');
const XLSX = require('xlsx');

// Read and parse the XML file
const xml = fs.readFileSync('C:\\Users\\AONE MANAGEMENT\\OneDrive\\Desktop\\scExcel\\ruleSets_rs.xml');
const parser = new xml2js.Parser();

parser.parseString(xml, (err, result) => {
    if (err) throw err;

    // Initialize data storage
    let data = {};

    // Iterate through each styleName element and group by ID
    result.styles.styleName.forEach(style => {
        const id = style.$.id;
        if (!data[id]) {
            data[id] = [];
        }
        data[id].push(style.$.name);
    });

    // Prepare Excel data
    const sheetData = [['ID', 'Names']]; // Header row
    Object.keys(data).forEach(id => {
        sheetData.push([id, data[id].join(', ')]);
    });

    // Create a new workbook and add the sheet
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.aoa_to_sheet(sheetData);

    // Set dropdown lists for the Names column
    const range = XLSX.utils.decode_range(ws['!ref']);
    for (let R = 1; R <= range.e.r; ++R) {
        const cell = ws[XLSX.utils.encode_cell({r: R, c: 1})];
        if (cell) {
            cell.t = 's';
            cell.z = data[sheetData[R][0]].join(';');
        }
    }

    // Add the worksheet to the workbook
    XLSX.utils.book_append_sheet(wb, ws, 'Styles');

    // Write the workbook to file
    XLSX.writeFile(wb, 'styles.xlsx');
});
