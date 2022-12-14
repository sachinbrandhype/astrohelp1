const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");
module.exports = (sequelize, Sequelize) => {
    const Yogavideo = sequelize.define('yoga_videos',{
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      yoga_id: {
        type: Sequelize.INTEGER,
      },
      file: {
        type: Sequelize.STRING
      },
      file_type: {
        type: Sequelize.INTEGER
      },
      created_at:  {
        type: 'TIMESTAMP',
        defaultValue: Sequelize.literal('CURRENT_TIMESTAMP'),
      },
      updated_at: {
        type: 'TIMESTAMP',
      },

      fileUrl: {
          type: DataTypes.VIRTUAL,
          get() {
            return `${imagePaths.yogavideo}${this.image}`;
          }
      }
    },{
        tableName: 'yoga_videos',
        timestamps: false,
        scopes:{
          orderAsc:{
            order: [
              ['created_at','asc'],
            ]
          },
          orderDesc:{
            order: [
              ['created_at','desc'],
            ]
          },
        }
    });

    return Yogavideo;
};
