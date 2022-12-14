module.exports = (sequelize, Sequelize) => {
    const Guest = sequelize.define("guests", {
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      names:{
          type:Sequelize.TEXT
      },
      user_id: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      total: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      status: {
        type: Sequelize.INTEGER.UNSIGNED
      },
    },{
        timestamps: false,
        tableName: 'guests',
        scopes:{
          active:{
            where:{status:1}
          },
        }
    });

    return Guest;
};