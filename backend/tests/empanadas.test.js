const request = require('supertest');
const app = require('../app');

describe('Empanadas API', () => {
    it('GET /api/empanadas should return array', async () => {
        const res = await request(app).get('/api/empanadas');
        expect(res.statusCode).toBe(200);
        expect(Array.isArray(res.body)).toBe(true);
    });
});