const express = require('express');
const router = express.Router();
const { body } = require('express-validator');
const ctrl = require('../controllers/empanadasController');

// cargar lista de empanadas
router.get('/empanadas', ctrl.listEmpanadas);

// agregar empanada
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

// editar empanada
router.put(
  '/empanada/:id',
  [
    body('price').optional().isDecimal().withMessage('El precio debe ser un número')
  ],
  ctrl.updateEmpanada
);

// Eliminar empanada
router.delete('/empanada/:id', ctrl.deleteEmpanada);

module.exports = router;