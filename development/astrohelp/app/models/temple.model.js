const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

module.exports = (sequelize, Sequelize) => {
    const God = sequelize.define("master_temple", {
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      name: {
        type: Sequelize.STRING
      },
      hindi_name: {
        type: Sequelize.STRING
      },
      gujrati_name: {
        type: Sequelize.STRING
      },
      added_on: {
        type: 'TIMESTAMP'
      },
      status:{
          type:Sequelize.INTEGER
      },
      is_selected: {
            type: DataTypes.VIRTUAL,
            get() {
            return '';
            }
        }
    },{
        timestamps: false,
        tableName: 'master_temple',
        scopes:{
          active:{
            where:{status:1}
          },
        }
    });

    return God;
};