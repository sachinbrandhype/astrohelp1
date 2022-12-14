module.exports = (sequelize, Sequelize) => {
    const Pujatimeslot = sequelize.define("puja_time_slots", {
      id: {
        primaryKey: true,
        type: Sequelize.INTEGER,
        autoIncrement: true,
      },
      puja_id: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      date: {
        type: 'DATE'
      },
      json: {
        type: Sequelize.STRING
      },
      stock: {
        type: Sequelize.INTEGER.UNSIGNED
      },
      added_on: {
        type: 'TIMESTAMP'
      },
      status: {
        type: Sequelize.INTEGER.UNSIGNED
      },
    },{
        timestamps: false,
        tableName: 'puja_time_slots',
    });

    return Pujatimeslot;
};