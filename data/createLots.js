const fs = require('fs');

// Lots to create
const LOTS = [54, 100];

/**
 * Generate the name in the ParkingLot query
 * @param lotNum
 * @returns {string} naming of the lot in the query
 */
function genLotName(lotNum) {
    return `Lot ${lotNum}`;
}

/**
 * Generate the ParkingLot query
 * @param lots
 * @returns {string}
 */
function genLotQuery(lots) {
    const query = "INSERT INTO `ParkingLot` (`id`, `name`, `created_date`) VALUES\n";

    const values = lots.map((i) => (
        `(NULL, '${genLotName(i)}', current_timestamp())`
    ));
    return `${query}${values.join(',\n')};`;
}

/**
 * Output the ParkingLot query to lots.sql
 */
if (require.main === module) {
    fs.writeFile('lots.sql', genLotQuery(LOTS), (err) => {
        if (err) throw err;
        console.log('Lots Query Created!');
    });
}

module.exports = {
    LOTS
};