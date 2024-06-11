const express = require('express');
const router = express.Router();
const path = require('path')


const excelFilePath = path.resolve('C:\\Users\\AONE MANAGEMENT\\OneDrive\\Desktop\\scExcel\\rules_template-new-1.xlsx');
router.get('/', (req, res) => {
    res.sendFile(path.resolve('C:\\Users\\AONE MANAGEMENT\\OneDrive\\Desktop\\scExcel\\public\\index.html'));
});

router.get('/view-excel', (req, res) => {
    res.sendFile(excelFilePath);
});

router.get('/contact', (req, res) => {
    res.send('Contact Page');
});

module.exports = router;
