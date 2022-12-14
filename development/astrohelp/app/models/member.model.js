const { DataTypes } = require("sequelize");

module.exports = (sequelize, Sequelize) => {
    const Member = sequelize.define("members", {
      id: {
        primaryKey: true,
        type: DataTypes.INTEGER,
        autoIncrement: true,
      },
      user_id: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      type: {
        type: DataTypes.STRING
      },
      name: {
        type: DataTypes.STRING
      },
      fathername: {
        type: DataTypes.STRING
      },
      mothername: {
        type: DataTypes.STRING
      },
      email: {
        type: DataTypes.STRING
      },
      phone: {
        type: DataTypes.STRING
      },
      zodiac: {
        type: DataTypes.STRING
      },
      occupation: {
        type: DataTypes.STRING
      },
      dob: {
        type: DataTypes.STRING
      },
      tob: {
        type: DataTypes.STRING
      },
      gender	: {
        type: DataTypes.STRING
      },
      pob	: {
        type: DataTypes.STRING
      },
      gotro	: {
        type: DataTypes.STRING
      },
      spouse	: {
        type: DataTypes.STRING
      },
      relation	: {
        type: DataTypes.STRING
      },
      location	: {
        type: DataTypes.STRING
      },
      message	: {
        type: DataTypes.STRING
      },

      latitude	: {
        type: DataTypes.STRING
      },
      longitude	: {
        type: DataTypes.STRING
      },
      status: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      created_at: {
        type: DataTypes.DATE
      },
      is_default:{
        type: DataTypes.INTEGER.UNSIGNED

      }
    },{
      tableName:'members',
        timestamps: false,
        scopes:{
          active:{
            where:{status:1}
          },
        }
    });

    return Member;
};