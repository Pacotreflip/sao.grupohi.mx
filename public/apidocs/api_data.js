define({ "api": [
  {
    "type": "patch",
    "url": "/contrato/{id}",
    "title": "Actualizar Contrato",
    "version": "1.0.0",
    "group": "Contrato",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Token de autorización</p>"
          },
          {
            "group": "Header",
            "type": "string",
            "optional": false,
            "field": "database_name",
            "description": "<p>Nombre de la Base de Datos para establecer contexto</p>"
          },
          {
            "group": "Header",
            "type": "string",
            "optional": false,
            "field": "id_obra",
            "description": "<p>ID De la obra sobre la que se desea extablecer el contexto</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:255",
            "optional": true,
            "field": "descripcion",
            "description": "<p>Descripción del nuevo contrato adjunto al contrato proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:16",
            "optional": true,
            "field": "unidad",
            "description": "<p>Unidad de medida del nuevo contrato adjunto al contrato proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "size": "max:16",
            "optional": true,
            "field": "cantidad_original",
            "description": "<p>Cantidad del nuevo contrato adjunto al contrato proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:140",
            "optional": true,
            "field": "clave",
            "description": "<p>Clave del nuevo contrato adjunto al contrato proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "id_marca",
            "description": "<p>Marca del nuevo contrato adjunto al contrato proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "id_modelo",
            "description": "<p>Modelo del nuevo contrato adjunto al contrato proyectado</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "StoreResourceFailedException",
            "description": "<p>Error al registrar un Contrato</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response",
          "content": "HTTP/1.1 422 Unprocessable Entity\n{\n  \"message\": \"error description\",\n  \"errors\": {\n    \"param\": [\"error 1\", \"error 2\"]\n    ...\n  },\n  \"status_code\": 422\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "200": [
          {
            "group": "200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Datos del Contrato Proyectado</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": {\n    \"id_transaccion\": 00000\n    \"descripcion\": \"ABCDE.....\",\n    \"unidad\": \"ABCDE...\",\n    \"cantidad_original\": \"000\",\n    \"cantidad_proyectada\": \"000\",\n    \"clave\": \"XXXXXX\",\n    \"id_marca\": 000,\n    \"id_modelo\": 000,\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Api/Controllers/ContratoController.php",
    "groupTitle": "Contrato",
    "name": "PatchContratoId"
  },
  {
    "type": "post",
    "url": "/contrato_proyectado",
    "title": "Registrar Contrato Proyectado",
    "version": "1.0.0",
    "group": "Contrato_Proyectado",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Token de autorización</p>"
          },
          {
            "group": "Header",
            "type": "string",
            "optional": false,
            "field": "database_name",
            "description": "<p>Nombre de la Base de Datos para establecer contexto</p>"
          },
          {
            "group": "Header",
            "type": "string",
            "optional": false,
            "field": "id_obra",
            "description": "<p>ID De la obra sobre la que se desea extablecer el contexto</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "fecha",
            "description": "<p>Fecha de Registro del Contrato Proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:64",
            "optional": false,
            "field": "referencia",
            "description": "<p>Referencia del nuevo Contrato Proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "DateTime",
            "optional": false,
            "field": "cumplimiento",
            "description": "<p>Fecha del inicio de cumplimiento del Contrato Proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "DateTime",
            "optional": false,
            "field": "vencimiento",
            "description": "<p>Fecha de Vencimiento del Contrato Proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "contratos",
            "description": "<p>Contratos para el Contrato Proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:255",
            "optional": false,
            "field": "contratos.nivel",
            "description": "<p>Nivel del nuevo contrato adjunto al contrato proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:255",
            "optional": false,
            "field": "contratos.descripcion",
            "description": "<p>Descripción del nuevo contrato adjunto al contrato proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:16",
            "optional": true,
            "field": "contratos.unidad",
            "description": "<p>Unidad de medida del nuevo contrato adjunto al contrato proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "size": "max:16",
            "optional": true,
            "field": "contratos.cantidad_original",
            "description": "<p>Cantidad del nuevo contrato adjunto al contrato proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:140",
            "optional": true,
            "field": "contratos.clave",
            "description": "<p>Clave del nuevo contrato adjunto al contrato proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "contratos.id_marca",
            "description": "<p>Marca del nuevo contrato adjunto al contrato proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "contratos.id_modelo",
            "description": "<p>Modelo del nuevo contrato adjunto al contrato proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": true,
            "field": "contratos.destinos",
            "description": "<p>Destinos del contrato</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "contratos.destinos.id_concepto",
            "description": "<p>ID del Concepto asociado al contrato</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "StoreResourceFailedException",
            "description": "<p>Error al registrar un Contrato Proyectado</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response",
          "content": "HTTP/1.1 422 Unprocessable Entity\n{\n  \"message\": \"error description\",\n  \"errors\": {\n    \"param\": [\"error 1\", \"error 2\"]\n    ...\n  },\n  \"status_code\": 422\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "200": [
          {
            "group": "200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Datos del Contrato Proyectado</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": {\n    \"id_transaccion\": 31557\n    \"fecha\": \"2017-11-07 00:00:00.000\",\n    \"referencia\": \"CONTRATO PROYECTADO NUEVO 07-11-2017\",\n    \"cumplimiento\": \"2017-11-06 00:00:00.000\",\n    \"vencimiento\": \"2017-11-07 00:00:00.000\",\n    \"id_obra\": \"1\",\n    \"FechaHoraRegistro\": \"2017-11-07 16:36:15\",\n    \"tipo_transaccion\": 49,\n    \"opciones\": 1026,\n    \"comentario\": \"I;07/11/2017 04:11:15;SCR|jfesquivel|\",\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Api/Controllers/ContratoProyectadoController.php",
    "groupTitle": "Contrato_Proyectado",
    "name": "PostContrato_proyectado"
  },
  {
    "type": "post",
    "url": "/contrato_proyectado/{id}/addContratos",
    "title": "Agregar Contratos Adjuntos a Contrato Proyectado",
    "version": "1.0.0",
    "group": "Contrato_Proyectado",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Token de autorización</p>"
          },
          {
            "group": "Header",
            "type": "string",
            "optional": false,
            "field": "database_name",
            "description": "<p>Nombre de la Base de Datos para establecer contexto</p>"
          },
          {
            "group": "Header",
            "type": "string",
            "optional": false,
            "field": "id_obra",
            "description": "<p>ID De la obra sobre la que se desea extablecer el contexto</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "contratos",
            "description": "<p>Arreglo de Objetos que contiene los contrato a registrar</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:255",
            "optional": false,
            "field": "contratos.nivel",
            "description": "<p>Nivel del nuevo contrato adjunto al contrato proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:255",
            "optional": false,
            "field": "contratos.descripcion",
            "description": "<p>Descripción del nuevo contrato adjunto al contrato proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:16",
            "optional": true,
            "field": "contratos.unidad",
            "description": "<p>Unidad de medida del nuevo contrato adjunto al contrato proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "size": "max:16",
            "optional": true,
            "field": "contratos.cantidad_original",
            "description": "<p>Cantidad del nuevo contrato adjunto al contrato proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:140",
            "optional": true,
            "field": "contratos.clave",
            "description": "<p>Clave del nuevo contrato adjunto al contrato proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "contratos.id_marca",
            "description": "<p>Marca del nuevo contrato adjunto al contrato proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "contratos.id_modelo",
            "description": "<p>Modelo del nuevo contrato adjunto al contrato proyectado</p>"
          },
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": true,
            "field": "contratos.destinos",
            "description": "<p>Destinos del contrato</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "contratos.destinos.id_concepto",
            "description": "<p>ID del Concepto asociado al contrato</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "StoreResourceFailedException",
            "description": "<p>Error al registrar un Contrato Proyectado</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response",
          "content": "HTTP/1.1 422 Unprocessable Entity\n{\n  \"message\": \"error description\",\n  \"errors\": {\n    \"param\": [\"error 1\", \"error 2\"]\n    ...\n  },\n  \"status_code\": 422\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "200": [
          {
            "group": "200",
            "type": "Object[]",
            "optional": false,
            "field": "data",
            "description": "<p>Contratos agregados al Contrato Proyectado</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": [\n    {\n      \"id_concepto\": 0000,\n      \"id_transaccion\": 1111,\n      \"descripcion\": \"ABCDE.....\",\n      \"nivel\": \"000.000.000.\",\n      \"unidad\": \"ABCDE\",\n      \"cantidad_original\": \"000\",\n      \"cantidad_proyectada\": \"000\",\n      \"clave\": \"XXXXX\",\n      \"id_marca\": 0000,\n      \"id_modelo\": 0000,\n      \"destinos\": \" [\n        {\n          \"id_concepto\": 00000\n        }\n      ]\n    },\n    ...\n  ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Api/Controllers/ContratoProyectadoController.php",
    "groupTitle": "Contrato_Proyectado",
    "name": "PostContrato_proyectadoIdAddcontratos"
  },
  {
    "type": "post",
    "url": "/empresa",
    "title": "Registrar Empresa",
    "version": "1.0.0",
    "group": "Empresa",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Token de autorización</p>"
          },
          {
            "group": "Header",
            "type": "string",
            "optional": false,
            "field": "database_name",
            "description": "<p>Nombre de la Base de Datos para establecer contexto</p>"
          },
          {
            "group": "Header",
            "type": "string",
            "optional": false,
            "field": "id_obra",
            "description": "<p>ID De la obra sobre la que se desea extablecer el contexto</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:16",
            "optional": false,
            "field": "rfc",
            "description": "<p>RFC de la Empresa</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:255",
            "optional": false,
            "field": "razon_social",
            "description": "<p>Razón Social de la Empresa</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "tipo_empresa",
            "description": "<p>Tipo de Empresa</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "dias_credito",
            "description": "<p>Días de Crédito</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:64",
            "optional": true,
            "field": "formato",
            "description": "<p>Formato de la Empresa</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:16",
            "optional": true,
            "field": "cuenta_contable",
            "description": "<p>Cuenta Contable de la empresa</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "tipo_cliente",
            "description": "<p>Tipo de Cliente</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "size": "min:0",
            "optional": true,
            "field": "porcentaje",
            "description": "<p>Porcentaje</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "no_proveedor_virtual",
            "description": "<p>Número de Proovedor Virtual</p>"
          },
          {
            "group": "Parameter",
            "type": "Nmber",
            "optional": true,
            "field": "personalidad",
            "description": "<p>Personalidad</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "StoreResourceFailedException",
            "description": "<p>Error al registrar una Empresa</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response",
          "content": "HTTP/1.1 422 Unprocessable Entity\n{\n  \"message\": \"error descropton\",\n  \"errors\": {\n    \"param\": [\"error 1\", \"error 2\"]\n    ...\n  },\n  \"status_code\": 422\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "200": [
          {
            "group": "200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Datos de la Empresa Registrada</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": {\n    \"id_empresa\": \"xxx\",\n    \"tipo_empresa\": \"x\",\n    \"razon_social\": \"Razón Social\",\n    \"rfc\": \"000000XXX\",\n    ...\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Api/Controllers/EmpresaController.php",
    "groupTitle": "Empresa",
    "name": "PostEmpresa"
  },
  {
    "type": "post",
    "url": "/estimacion",
    "title": "Registrar Estimación",
    "version": "1.0.0",
    "group": "Estimaci_n",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Token de autorización</p>"
          },
          {
            "group": "Header",
            "type": "string",
            "optional": false,
            "field": "database_name",
            "description": "<p>Nombre de la Base de Datos para establecer contexto</p>"
          },
          {
            "group": "Header",
            "type": "string",
            "optional": false,
            "field": "id_obra",
            "description": "<p>ID De la obra sobre la que se desea extablecer el contexto</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id_antecedente",
            "description": "<p>Id del Subcontrato al cuál está haciendo referencia la Estimación</p>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "fecha",
            "description": "<p>Fecha de registro</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id_empresa",
            "description": "<p>Id de la Empresa</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id_moneda",
            "description": "<p>Id del Tipo de Moneda</p>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "vencimiento",
            "description": "<p>Fecha de Vencimiento de la Estimación</p>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "cumplimiento",
            "description": "<p>Fecha de Cumplimiento de la Estimación</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:4096",
            "optional": false,
            "field": "observaciones",
            "description": "<p>Observaciones de la Estimación</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:64",
            "optional": false,
            "field": "referencia",
            "description": "<p>Referencia de la Estimación</p>"
          },
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "items",
            "description": "<p>Items de la Estimación</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "items.item_antecedente",
            "description": "<p>Id del Item Antecedente</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "items.cantidad",
            "description": "<p>Cantidad del Item de la Estimación</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "StoreResourceFailedException",
            "description": "<p>Error al registrar una Estimación</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response",
          "content": "HTTP/1.1 422 Unprocessable Entity\n{\n  \"message\": \"error description\",\n  \"errors\": {\n    \"param\": [\"error 1\", \"error 2\"]\n    ...\n  },\n  \"status_code\": 422\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "200": [
          {
            "group": "200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Datos de la Estimación Registrada</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response",
          "content": "HTTP/1.1 200 OK\n{\n  {\n   \"data\": {\n       \"id_antecedente\": 12345,\n       \"fecha\": \"2017-11-24 00:00:00.000\",\n       \"id_empresa\": 123,\n       \"id_moneda\": 1,\n       \"vencimiento\": \"2017-01-03 00:00:00.000\",\n       \"cumplimiento\": \"2017-01-02 00:00:00.000\",\n       \"referencia\": \"Prueba API\",\n       \"opciones\": 0,\n       \"id_obra\": \"1\",\n       \"FechaHoraRegistro\": \"2017-01-01 20:00:00\",\n       \"tipo_transaccion\": 52,\n       \"comentario\": \"I;01/01/2017 08:11:00;SAO|usuario|\",\n       \"id_transaccion\": 12345,\n       \"anticipo\": \"0.0\",\n       \"retencion\": \"0.0\",\n       \"saldo\": 12345.6,\n       \"monto\": 12345.6,\n       \"impuesto\": 12345.6\n     }\n   }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Api/Controllers/EstimacionController.php",
    "groupTitle": "Estimaci_n",
    "name": "PostEstimacion"
  },
  {
    "type": "patch",
    "url": "/item/{id}",
    "title": "Actualizar un Item",
    "version": "1.0.0",
    "group": "Item",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Token de autorización</p>"
          },
          {
            "group": "Header",
            "type": "string",
            "optional": false,
            "field": "database_name",
            "description": "<p>Nombre de la Base de Datos para establecer contexto</p>"
          },
          {
            "group": "Header",
            "type": "string",
            "optional": false,
            "field": "id_obra",
            "description": "<p>ID De la obra sobre la que se desea extablecer el contexto</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "cantidad",
            "description": "<p>Cantidad del Item a Acualizar de la Estimación</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "StoreResourceFailedException",
            "description": "<p>Error al Actualizar un Item</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response",
          "content": "HTTP/1.1 422 Unprocessable Entity\n{\n  \"message\": \"error description\",\n  \"errors\": {\n    \"param\": [\"error 1\", \"error 2\"]\n    ...\n  },\n  \"status_code\": 422\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "200": [
          {
            "group": "200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Datos del Item Actualizado</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": {\n     \"id_item\": 12345,\n     \"id_transaccion\": \"12345\",\n     \"id_antecedente\": null,\n     \"item_antecedente\": null,\n     \"id_almacen\": null,\n     \"id_concepto\": \"12345\",\n     \"id_material\": null,\n     \"unidad\": null,\n     \"numero\": \"0\",\n     \"cantidad\": 1234,\n     \"cantidad_material\": \"0.0\",\n     \"cantidad_mano_obra\": \"0.0\",\n     \"importe\": \"0.0\",\n     \"saldo\": \"0.0\",\n     \"precio_unitario\": 123,\n     \"anticipo\": \"0.0\",\n     \"descuento\": \"0.0\",\n     \"precio_material\": \"0.0\",\n     \"precio_mano_obra\": \"0.0\",\n     \"autorizado\": \"0.0\",\n     \"referencia\": null,\n     \"estado\": \"0\",\n     \"cantidad_original1\": \"0.0\",\n     \"cantidad_original2\": \"0.0\",\n     \"precio_original1\": \"0.0\",\n     \"precio_original2\": \"0.0\",\n     \"id_asignacion\": null\n   }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Api/Controllers/ItemController.php",
    "groupTitle": "Item",
    "name": "PatchItemId"
  },
  {
    "type": "post",
    "url": "/item",
    "title": "Registrar Item",
    "version": "1.0.0",
    "group": "Item",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Token de autorización</p>"
          },
          {
            "group": "Header",
            "type": "string",
            "optional": false,
            "field": "database_name",
            "description": "<p>Nombre de la Base de Datos para establecer contexto</p>"
          },
          {
            "group": "Header",
            "type": "string",
            "optional": false,
            "field": "id_obra",
            "description": "<p>ID De la obra sobre la que se desea extablecer el contexto</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "id_transaccion",
            "description": "<p>Id del Subcontrato al cuál se Agregara el Item</p>"
          },
          {
            "group": "Parameter",
            "type": "Numeric",
            "optional": false,
            "field": "cantidad",
            "description": "<p>Cantidad del Item</p>"
          },
          {
            "group": "Parameter",
            "type": "Numeric",
            "optional": false,
            "field": "precio_unitario",
            "description": "<p>Precio Unitario del item</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "StoreResourceFailedException",
            "description": "<p>Error al registrar un Item</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response",
          "content": "HTTP/1.1 422 Unprocessable Entity\n{\n  \"message\": \"error description\",\n  \"errors\": {\n    \"param\": [\"error 1\", \"error 2\"]\n    ...\n  },\n  \"status_code\": 422\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "200": [
          {
            "group": "200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Datos del Item</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response",
          "content": "HTTP/1.1 200 OK\n{\n   \"data\": {\n      \"id_transaccion\": \"12345\",\n      \"cantidad\": 12345,\n      \"precio_unitario\": 123,\n      \"id_concepto\": \"12345\",\n      \"id_item\": 12345\n   }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Api/Controllers/ItemController.php",
    "groupTitle": "Item",
    "name": "PostItem"
  },
  {
    "type": "post",
    "url": "/subcontrato",
    "title": "Registrar Subcontrato",
    "version": "1.0.0",
    "group": "Subcontrato",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Token de autorización</p>"
          },
          {
            "group": "Header",
            "type": "string",
            "optional": false,
            "field": "database_name",
            "description": "<p>Nombre de la Base de Datos para establecer contexto</p>"
          },
          {
            "group": "Header",
            "type": "string",
            "optional": false,
            "field": "id_obra",
            "description": "<p>ID De la obra sobre la que se desea extablecer el contexto</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id_antecedente",
            "description": "<p>Id del Contrato Proyectado al cual hace Feferencia el Subcontrato</p>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "fecha",
            "description": "<p>Fecha del Subcontrato</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id_costo",
            "description": "<p>Id del Costo Asociado al Subcontrato</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id_empresa",
            "description": "<p>Id de la Empresa Asociada al Subcontrato</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id_moneda",
            "description": "<p>Id de la Moneda del Subcontrato</p>"
          },
          {
            "group": "Parameter",
            "type": "Numeric",
            "optional": true,
            "field": "anticipo",
            "description": "<p>Porcentaje de Anticipo al Subcontrato</p>"
          },
          {
            "group": "Parameter",
            "type": "Numeric",
            "optional": true,
            "field": "retencion",
            "description": "<p>Porcentaje de Retención del Subcontrato</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:64",
            "optional": true,
            "field": "referencia",
            "description": "<p>Referencia unica del Subcontrato</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:4096",
            "optional": false,
            "field": "observaciones",
            "description": "<p>Observaciones del Subcontrato</p>"
          },
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "items",
            "description": "<p>Items del Subcontrato</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "items.id_concepto",
            "description": "<p>Id Concepto del Contrato Asociado al Subcontrato</p>"
          },
          {
            "group": "Parameter",
            "type": "Numeric",
            "optional": false,
            "field": "items.cantidad",
            "description": "<p>Cantidad del Item del Subcontrato</p>"
          },
          {
            "group": "Parameter",
            "type": "Numeric",
            "optional": false,
            "field": "items.precio_unitario",
            "description": "<p>Precio Unitario del Item del SubcoapiParam</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "StoreResourceFailedException",
            "description": "<p>Error al registrar un Subcontrato</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response",
          "content": "HTTP/1.1 422 Unprocessable Entity\n{\n  \"message\": \"error description\",\n  \"errors\": {\n    \"param\": [\"error 1\", \"error 2\"]\n    ...\n  },\n  \"status_code\": 422\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "200": [
          {
            "group": "200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Datos del Subcontrato Registrado</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": {\n     \"id_antecedente\": 12345,\n     \"fecha\": \"2017-01-01 00:00:00.000\",\n     \"id_costo\": 123,\n     \"id_empresa\": 123,\n     \"id_moneda\": 1,\n     \"referencia\": \"Prueba API\",\n     \"opciones\": 2,\n     \"id_obra\": \"1\",\n     \"FechaHoraRegistro\": \"2017-01-01 12:00:00\",\n     \"tipo_transaccion\": 51,\n     \"comentario\": \"I;01/01/2017 11:11:18;SAO|usuario|\",\n     \"id_transaccion\": 1234,\n     \"saldo\": \"37500.0\",\n     \"monto\": \"37500.0\",\n     \"impuesto\": 12345.67,\n     \"anticipo_saldo\": 0,\n     \"anticipo_monto\": 0\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Api/Controllers/SubcontratoController.php",
    "groupTitle": "Subcontrato",
    "name": "PostSubcontrato"
  },
  {
    "type": "post",
    "url": "/sucursal",
    "title": "Registrar Sucursal",
    "version": "1.0.0",
    "group": "Sucursal",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Authorization",
            "description": "<p>Token de autorización</p>"
          },
          {
            "group": "Header",
            "type": "string",
            "optional": false,
            "field": "database_name",
            "description": "<p>Nombre de la Base de Datos para establecer contexto</p>"
          },
          {
            "group": "Header",
            "type": "string",
            "optional": false,
            "field": "id_obra",
            "description": "<p>ID De la obra sobre la que se desea extablecer el contexto</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id_empresa",
            "description": "<p>Identificador de la Empresa a la que pertenecerá la Sucursal</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:255",
            "optional": false,
            "field": "descripcion",
            "description": "<p>Descripción de la Sucursal</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:255",
            "optional": true,
            "field": "direccion",
            "description": "<p>Dirección de la Sucursal</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:255",
            "optional": true,
            "field": "ciudad",
            "description": "<p>Ciudad de la Sucursal</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:255",
            "optional": true,
            "field": "estado",
            "description": "<p>Estado de la Sucursal</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "size": "5",
            "optional": true,
            "field": "codigo_postal",
            "description": "<p>CP de la Sucursal</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:255",
            "optional": true,
            "field": "telefono",
            "description": "<p>Teléfono de la Sucursal</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:255",
            "optional": true,
            "field": "fax",
            "description": "<p>FAX de la Sucursal</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:255",
            "optional": true,
            "field": "contacto",
            "description": "<p>Nombre del Contacto de la Sucursal</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "1",
            "allowedValues": [
              "\"N\"",
              "\"S\""
            ],
            "optional": true,
            "field": "casa_central",
            "description": "<p>Indica si es o no Casa Central</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:50",
            "optional": true,
            "field": "email",
            "description": "<p>Email de la Sucursal</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:50",
            "optional": true,
            "field": "cargo",
            "description": "<p>Cargo de la Sucursal</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:50",
            "optional": true,
            "field": "telefono_movil",
            "description": "<p>Teléfono Móvil de la Sucursal</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:500",
            "optional": true,
            "field": "observaciones",
            "description": "<p>Observaciones</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "StoreResourceFailedException",
            "description": "<p>Error al registrar una Sucursal</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response",
          "content": "HTTP/1.1 422 Unprocessable Entity\n{\n  \"message\": \"error descropton\",\n  \"errors\": {\n    \"param\": [\"error 1\", \"error 2\"]\n    ...\n  },\n  \"status_code\": 422\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "200": [
          {
            "group": "200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Datos de la Sucursal Registrada</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": {\n    \"id_sucursal\": \"123\",\n    \"id_empresa\": \"123\",\n    \"descripcion\": \"Descripción\",\n    \"UsuarioRegistro\": \"0001\",\n    \"FechaHoraRegistro\": \"2000-01-01 12:00:00\",\n    ...\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Api/Controllers/SucursalController.php",
    "groupTitle": "Sucursal",
    "name": "PostSucursal"
  }
] });
