const { DataTypes } = require("sequelize");
module.exports = (sequelize, Sequelize) => {
    const Banner = sequelize.define("book_broadcast", {
      id: {
        primaryKey: true,
        type: DataTypes.INTEGER,
        autoIncrement: true,
      },
      user_id: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      astrologer_id: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      broadcast_id: {
        type: DataTypes.INTEGER.UNSIGNED
      },
      price: {
        type: DataTypes.FLOAT
      },
      txn_id: {
        type: DataTypes.STRING
      },
      created_at: {
        type: DataTypes.DATE
      },
    },{
        timestamps: false,
        tableName: 'book_broadcast',
        scopes:{
        }
    });

    return Banner;
};