const ExcelJS = require('exceljs');
const { extractRulesFromXML } = require('./ExtractXml');
const fs = require('fs')

const createExcelTemplate = async (rulesPerFile,fileNames, outputFile) => {
    const workbook = new ExcelJS.Workbook();

    rulesPerFile.forEach((rules, index) => {
        const sheetName = fileNames[index];
        const sheet = workbook.addWorksheet(sheetName);

        // Headers
        const headers = ['ID', 'Name', 'Functions', 'Description'];
        sheet.addRow(headers);

        rules.forEach(rule => {
            if(rule.description===''){
                rule.description = 'empty'
            }
            const row = [
                rule.id,
                rule.name,
                rule.functions.join(', '),
                rule.description,
                ''
            ];
            sheet.addRow(row);
        });
    });

    await workbook.xlsx.writeFile(outputFile);
};

const xmlPath = "C:\\Users\\AONE MANAGEMENT\\OneDrive\\Desktop\\scExcel\\testing\\ruleSets_rs.xml"
extractRulesFromXML(xmlPath)
    .then(rules => createExcelTemplate(rules, 'sc_rules.xlsx'))
    .catch(err => {
        console.error(err);
    });
