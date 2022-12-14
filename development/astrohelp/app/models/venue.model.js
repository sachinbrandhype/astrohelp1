const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

module.exports = (sequelize, Sequelize) => {
    const Venue = sequelize.define("venues", {
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      city_id: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      name: {
        type: Sequelize.STRING
      },
      position: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      status: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      created_at: {
        type: 'TIMESTAMP'
      },
      isSelected: {
        type: Sequelize.VIRTUAL,
        get() {
            return '';
        }
      },
    },{
        timestamps: false,
        tableName: 'venues',
        scopes:{
          active:{
            where:{status:1}
          },
          orderAsc:{
            order: [
              ['position','asc'],
            ]
          },
        }
    });

    return Venue;
};