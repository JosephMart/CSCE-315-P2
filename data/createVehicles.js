const fs = require('fs');
const XLSX = require('xlsx');
const LOTS = require("./createLots.js").LOTS;

/**
 * You first need to create a formatting function to pad numbers to two digits…
 **/
function twoDigits(d) {
    if(0 <= d && d < 10) return "0" + d.toString();
    if(-10 < d && d < 0) return "-0" + (-1*d).toString();
    return d.toString();
}
Date.prototype.toMysqlFormat = function() {
    return this.getFullYear() + "-" + twoDigits(1 + this.getMonth()) + "-" + twoDigits(this.getDate()) + " " + twoDigits(this.getHours()) + ":" + twoDigits(this.getMinutes()) + ":" + twoDigits(this.getSeconds());
};

function genVehiclesQuery(rows) {
    const query = "INSERT INTO `Vehicle` (`id`, `time`, `entering`, `lot_id`) VALUES\n";

    const values = [];
    let date, entering;
    for (let r of rows) {
        date = new Date(r['Purchased Date']).toMysqlFormat();
        entering = r['Entry-Exit'];
        values.push(`(NULL, '${date}', '${entering}', '1')`);
    }
    return `${query}${values.join(',\n')};`;
}

if (require.main === module) {
    const data = XLSX.readFile('Sample Parking Data (1 - entered, 0 - exited).xlsx');
    const sheetData = data.Sheets['Sheet1'];
    const rows = XLSX.utils.sheet_to_json(sheetData);
    fs.writeFile('vehicles.sql', genVehiclesQuery(rows), (err) => {
        if (err) throw err;
        console.log('Vehicles Query Created!');
    });
}