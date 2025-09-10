const request = require('supertest');
const express = require('express');
const bodyParser = require('body-parser');
const empanadasController = require('../src/controllers/empanadasController'); 
const pool = require('../src/models/db'); // <-- importante

const app = express();
app.use(bodyParser.json());

// Rutas de prueba
app.get('/api/empanadas', empanadasController.listEmpanadas);
app.post('/api/empanada', empanadasController.createEmpanada);
app.put('/api/empanada/:id', empanadasController.updateEmpanada);
app.delete('/api/empanada/:id', empanadasController.deleteEmpanada);

describe('API Empanadas', () => {
  let createdId;

  test('Listar empanadas', async () => {
    const res = await request(app).get('/api/empanadas');
    expect(res.statusCode).toBe(200);
    expect(Array.isArray(res.body)).toBe(true);
  });

  test('Crear empanada', async () => {
    const res = await request(app)
      .post('/api/empanada')
      .send({ name: 'Empanada Test', type: 'Horno', filling: 'Carne', price: 1500 });
    expect(res.statusCode).toBe(201);
    expect(res.body.name).toBe('Empanada Test');
    createdId = res.body.id;
  });

  test('Actualizar empanada', async () => {
    const res = await request(app)
      .put(`/api/empanada/${createdId}`)
      .send({ price: 2000, is_sold_out: true });
    expect(res.statusCode).toBe(200);
    expect(res.body.price).toBe(2000);
    expect(res.body.is_sold_out).toBe(1);
  });

  test('Eliminar empanada', async () => {
    const res = await request(app)
      .delete(`/api/empanada/${createdId}`);
    expect(res.statusCode).toBe(204);
  });
});

// Cerrar pool de MySQL al final
afterAll(async () => {
  await pool.end();
});