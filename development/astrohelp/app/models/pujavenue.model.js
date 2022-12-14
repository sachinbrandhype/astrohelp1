module.exports = (sequelize, Sequelize) => {
    const Pujavenue = sequelize.define("puja_venues", {
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      city_id: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      venue_ids: {
        type: Sequelize.STRING
      },
      created_at: {
        type: 'TIMESTAMP'
      },
    },{
        timestamps: false,
        tableName: 'puja_venues',
    });

    return Pujavenue;
};