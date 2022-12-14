const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");
module.exports = (sequelize, Sequelize) => {
    const Yoga = sequelize.define('yogas',{
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      name: {
        type: Sequelize.STRING
      },
      description: {
        type: Sequelize.TEXT
      },
      image: {
        type: Sequelize.STRING
      },
      price: {
        type: Sequelize.FLOAT
      },
      // validity: {
      //   type: Sequelize.INTEGER
      // },
      // duration: {
      //   type: Sequelize.STRING
      // },
      status: {
        type: Sequelize.INTEGER
      },
      position: {
        type: Sequelize.INTEGER
      },
      created_at: {
        type: Sequelize.STRING
      },
      updated_at: {
        type: Sequelize.STRING
      },

      imageUrl: {
          type: DataTypes.VIRTUAL,
          get() {
            return `${imagePaths.yoga}${this.image}`;
          }
      }
    },{
        tableName: 'yogas',
        timestamps: false,
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

    return Yoga;
};
