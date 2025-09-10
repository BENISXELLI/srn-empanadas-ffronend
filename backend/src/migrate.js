const pool = require('./models/db');

async function migrate() {
  try {
    console.log('Iniciando migración...');

    await pool.query(`
      CREATE TABLE IF NOT EXISTS empanadas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        type VARCHAR(255) NOT NULL,
        filling TEXT,
        price INT, -- precios en pesos chilenos
        is_sold_out BOOLEAN DEFAULT FALSE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
      )
    `);

    console.log('Migración completada: tabla empanadas creada');

    const [rows] = await pool.query('SELECT COUNT(*) as count FROM empanadas');
    if (rows[0].count === 0) {
      await pool.query(`
        INSERT INTO empanadas (name, type, filling, price) VALUES
        ('Pino', 'Horno', 'Carne y cebolla', 2500),
        ('Queso', 'Frita', 'Queso', 2000),
        ('Vegetariana', 'Horno', 'Verduras varias', 2500),
        ('Camarón Queso', 'Frita', 'Camarón y queso', 3000),
        ('Napolitana', 'Horno', 'Jamón, queso y tomate', 3000),
        ('Mariscos', 'Horno', 'Mezcla de mariscos', 3000)
      `);
      console.log('🍴 Datos iniciales en CLP insertados');
    }

    process.exit(0);
  } catch (err) {
    console.error('Error en migración:', err);
    process.exit(1);
  }
}

migrate();