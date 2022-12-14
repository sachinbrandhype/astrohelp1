const { DataTypes } = require("sequelize");

const { imagePaths } = require("../config/app.config");

// const { DataTypes } = require("sequelize");
module.exports = (sequelize, Sequelize) => {
    const Ropeway = sequelize.define("ropeway", {
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      image: {
        type: Sequelize.STRING
      },
      title: {
        type: Sequelize.STRING
      },
      hindi_title: {
        type: Sequelize.STRING
      },
      gujrati_title: {
        type: Sequelize.STRING
      },
      subtitle: {
        type: Sequelize.STRING
      },
      hindi_subtitle: {
        type: Sequelize.STRING
      },
      gujrati_subtitle: {
        type: Sequelize.STRING
      },

      description: {
        type: Sequelize.STRING
      },
      hindi_description: {
        type: Sequelize.STRING
      },
      gujrati_description: {
        type: Sequelize.STRING
      },
      location : {
        type: Sequelize.STRING
      },

      status: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      added_on: {
        type: 'TIMESTAMP'
      },
      imageUrl: {
        type: DataTypes.VIRTUAL,
        get() {
          return `${imagePaths.ropeway}${this.image}`;
        }
    }
    },{
        tableName:'ropeway',
        timestamps: false,
        scopes:{
          active:{
            where:{status:1}
          },
        }
    });

    return Ropeway;
};