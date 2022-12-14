const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

module.exports = (sequelize, Sequelize) => {
    const ledger_code = sequelize.define("ledger_code", {
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      ledger_name: {
        type: Sequelize.STRING
      },
    },{
        timestamps: false,
        tableName: 'ledger_code',
        scopes:{
        }
    });

    return ledger_code;
};