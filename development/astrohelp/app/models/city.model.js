const { DataTypes } = require("sequelize");

module.exports = (sequelize, Sequelize) => {
    const City = sequelize.define("puja_location", {
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      name:{
          type:Sequelize.STRING
      },
      // state_id: {
      //   type: Sequelize.INTEGER.UNSIGNED
      // },
      status: {
        type: Sequelize.INTEGER.UNSIGNED
      },

       is_selected: {
          type: DataTypes.VIRTUAL,
          get() {
            return '';
          }
      }
    },{
        timestamps: false,
        tableName: 'puja_location',
        scopes:{
          active:{
            where:{status:1}
          },
        }
    });

    return City;
};