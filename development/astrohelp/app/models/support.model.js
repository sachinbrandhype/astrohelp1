const { DataTypes } = require("sequelize");
const { imagePaths } = require("../config/app.config");
module.exports = (sequelize, Sequelize) => {
    const Support = sequelize.define('user_support',{

      id: {
        primaryKey: true,
        type: DataTypes.INTEGER,
        autoIncrement: true,
      },
      name: {
        type: DataTypes.STRING
      },
      email: {
        type: DataTypes.STRING
      },
      mobile: {
        type: DataTypes.STRING
      },
      subject: {
        type: DataTypes.TEXT
      },
      message: {
        type: DataTypes.TEXT
      },
      status: {
        type: DataTypes.INTEGER
      },
      user_id: {
        type: DataTypes.INTEGER
      },
      added_on: {
        type: DataTypes.DATE
      },
    },{
        tableName: 'user_support',
        timestamps: false,
        // scopes:{
        //   active:{
        //     where:{status:1}
        //   },
        // }
    });

    return Support;
};
