const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

module.exports = (sequelize, Sequelize) => {
    const Banner = sequelize.define("cancellations_reasons", {
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
     title:{
         type:DataTypes.STRING,
     },
    position : {
        type:DataTypes.STRING,
    }
    },{
        timestamps: false,
        tableName: 'cancellations_reasons',
        scopes:{
          orderAsc:{
            order: [
              ['position','asc'],
            ]
          },
        }
    });

    return Banner;
};