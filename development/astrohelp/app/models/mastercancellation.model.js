module.exports = (sequelize, Sequelize) => {
    const Member = sequelize.define("master_cancellation", {
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      type: {
        type: Sequelize.STRING
      },
      less_than_12_hours: {
        type: Sequelize.INTEGER
      },
      between_12_to_24_hours: {
        type: Sequelize.INTEGER
      },
      before_24_hours: {
        type: Sequelize.INTEGER
      }
    },{
      tableName:'master_cancellation',
        timestamps: false,
        scopes:{
          puja:{
            where:{type:'puja_cancellation'}
          },
          astrologer:{
            where:{type:'astrology'}
          },
        }
    });

    return Member;
};