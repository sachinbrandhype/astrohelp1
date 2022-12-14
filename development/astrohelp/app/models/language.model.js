const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

module.exports = (sequelize, Sequelize) => {
    const Language = sequelize.define("language_categories", {
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      language_name:{
        type: Sequelize.INTEGER
      },
      name: {
            type: DataTypes.VIRTUAL,
            get() {
            return this.language_name.toUpperCase();;
            }
        },

        is_selected: {
          type: DataTypes.VIRTUAL,
          get() {
              return '';
          }
      }
     
    },{
        timestamps: false,
        tableName: 'language_categories',
    });

    return Language;
};