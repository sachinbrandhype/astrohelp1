const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");

module.exports = (sequelize, Sequelize) => {
    const Horoscope = sequelize.define("horoscopes", {
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      name: {
        type: Sequelize.STRING
      },
      image: {
        type: Sequelize.STRING
      },
      status: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      position: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      start_date: {
        type: Sequelize.STRING
      },
      end_date: {
        type: Sequelize.STRING
      },
      description: {
        type: Sequelize.STRING
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
                return `${imagePaths.horoscope}${this.image}`;
            }
        }
    },{
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

    return Horoscope;
};