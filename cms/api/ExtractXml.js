const fs = require('fs');
const path = require('path');
const libxmljs = require('libxmljs2');

// const extractRulesFromXML = (filePath) => {
//     return new Promise((resolve, reject) => {
//         fs.readFile(filePath, 'utf8', (err, xml) => {
//             if (err) {
//                 reject(err);
//                 return;
//             }

//             const xmlDoc = libxmljs.parseXml(xml);

//             const rules = [];

//             const styleNames = xmlDoc.find('//styleName');
//             styleNames.forEach(style => {
//                 const rule = {
//                     id: style.attr('id') ? style.attr('id').value() : '',
//                     name: style.attr('name') ? style.attr('name').value() : '',
//                     xpath: style.attr('xpath') ? style.attr('xpath').value() : '',
//                     functions: [],
//                     description: style.find('description').length ? style.find('description')[0].text() : ''
//                 };

//                 const functions = style.find('function');
//                 functions.forEach(func => {
//                     rule.functions.push(func.attr('name') ? func.attr('name').value() : '');
//                 });

//                 rules.push(rule);
//             });

//             resolve(rules);
//         });
//     });
// };

// const extractRulesFromDirectory = (dirPath) => {
//     return new Promise((resolve, reject) => {
//         fs.readdir(dirPath, (err, files) => {
//             if (err) {
//                 reject(err);
//                 return;
//             }

//             const xmlFiles = files.filter(file => path.extname(file) === '.xml');
//             const xmlFilePaths = xmlFiles.map(file => path.join(dirPath, file));
//             const fileNames = xmlFiles.map(file => path.basename(file, '.xml'));

//             Promise.all(xmlFilePaths.map(filePath => extractRulesFromXML(filePath)))
//                 .then(results => resolve([results, fileNames]))
//                 .catch(error => reject(error));
//         });
//     });
// };

// module.exports = { extractRulesFromDirectory };

const extractRulesFromXML = (filePath) => {
    return new Promise((resolve, reject) => {
        fs.readFile(filePath, 'utf8', (err, xml) => {
            if (err) {
                reject(err);
                return;
            }

            const xmlDoc = libxmljs.parseXml(xml);

            const rules = [];

            const styleNames = xmlDoc.find('//styleName');
            styleNames.forEach(style => {
                const rule = {
                    id: style.attr('id') ? style.attr('id').value() : '',
                    name: style.attr('name') ? style.attr('name').value() : '',
                    xpath: style.attr('xpath') ? style.attr('xpath').value() : '',
                    functions: [],
                    description: style.find('description').length ? style.find('description')[0].text() : ''
                };

                const functions = style.find('function');
                functions.forEach(func => {
                    rule.functions.push(func.attr('name') ? func.attr('name').value() : '');
                });

                rules.push(rule);
            });

            resolve(rules);
        });
    });
};

module.exports = { extractRulesFromXML };