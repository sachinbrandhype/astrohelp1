module.exports = {
    HOST: "localhost",
    USER: "root",
    PASSWORD: "Astrohelp24@#$DB",
    DB: "new_db24",
    dialect: "mysql",
    pool: {
      max: 5,
      min: 0,
      acquire: 30000,
      idle: 10000
    }
};