const express = require('express');
const router = express.Router();
const { body } = require('express-validator');
const ctrl = require('../controllers/empanadasController');

// Listar
router.get('/empanadas', ctrl.listEmpanadas);

// Crear
router.post(
  '/empanada',
  [
    body('name').notEmpty().withMessage('El nombre es obligatorio'),
    body('type').notEmpty().withMessage('El tipo es obligatorio'),
    body('filling').notEmpty().withMessage('El relleno es obligatorio'),
    body('price').optional().isDecimal().withMessage('El precio debe ser un número')
  ],
  ctrl.createEmpanada
);

// Actualizar
router.put(
  '/empanada/:id',
  [
    body('price').optional().isDecimal().withMessage('El precio debe ser un número')
  ],
  ctrl.updateEmpanada
);

// Eliminar
router.delete('/empanada/:id', ctrl.deleteEmpanada);

module.exports = router;