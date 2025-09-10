const pool = require('../models/db');
const { validationResult } = require('express-validator');

const listEmpanadas = async (req, res, next) => {
  try {
    const [rows] = await pool.query('SELECT * FROM empanadas ORDER BY id ASC');
    res.json(rows);
  } catch (err) {
    next(err);
  }
};

const createEmpanada = async (req, res, next) => {
  try {
    const errors = validationResult(req);
    if (!errors.isEmpty()) return res.status(400).json({ errors: errors.array() });

    const { name, type, filling = null, price = null, is_sold_out = false } = req.body;
    const [result] = await pool.query(
      'INSERT INTO empanadas (name, type, filling, price, is_sold_out) VALUES (?, ?, ?, ?, ?)',
      [name, type, filling, price, is_sold_out ? 1 : 0]
    );
    const [rows] = await pool.query('SELECT * FROM empanadas WHERE id = ?', [result.insertId]);
    res.status(201).json(rows[0]);
  } catch (err) {
    next(err);
  }
};

const updateEmpanada = async (req, res, next) => {
  try {
    const errors = validationResult(req);
    if (!errors.isEmpty()) return res.status(400).json({ errors: errors.array() });

    const id = req.params.id;
    const fields = [];
    const values = [];

    ['name','type','filling','price','is_sold_out'].forEach(k => {
      if (req.body[k] !== undefined) {
        fields.push(`${k} = ?`);
        values.push(req.body[k]);
      }
    });

    if (fields.length === 0) return res.status(400).json({ error: 'No fields to update' });
    values.push(id);

    await pool.query(`UPDATE empanadas SET ${fields.join(', ')} WHERE id = ?`, values);
    const [rows] = await pool.query('SELECT * FROM empanadas WHERE id = ?', [id]);
    if (rows.length === 0) return res.status(404).json({ error: 'Not found' });
    res.json(rows[0]);
  } catch (err) {
    next(err);
  }
};

const deleteEmpanada = async (req, res, next) => {
  try {
    const id = req.params.id;
    const [result] = await pool.query('DELETE FROM empanadas WHERE id = ?', [id]);
    if (result.affectedRows === 0) return res.status(404).json({ error: 'Not found' });
    res.status(204).send();
  } catch (err) {
    next(err);
  }
};

module.exports = {
  listEmpanadas,
  createEmpanada,
  updateEmpanada,
  deleteEmpanada
};