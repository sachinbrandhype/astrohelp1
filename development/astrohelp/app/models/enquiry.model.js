const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");
module.exports = (sequelize, Sequelize) => {
    const Enquiry = sequelize.define('enquiries',{
      id: {
        primaryKey: true,
        type: DataTypes.INTEGER,
        autoIncrement: true,
      },
      user_id: {
        type: DataTypes.INTEGER
      },
      type: {
        type: DataTypes.INTEGER
      },
      type_id: {
        type: DataTypes.INTEGER
      },
      name: {
        type: DataTypes.STRING
      },
      email: {
        type: DataTypes.STRING
      },
      phone: {
        type: DataTypes.STRING
      },
      subject: {
        type: DataTypes.STRING
      },
      message: {
        type: DataTypes.TEXT
      },
      date: {
        type: DataTypes.DATE
      },
      created_at:{
          type:DataTypes.DATE
      }
    },{
        tableName: 'enquiries',
        timestamps: false,
    });

    return Enquiry;
};
