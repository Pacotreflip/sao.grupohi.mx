define({ "api": [
  {
    "type": "post",
    "url": "/contrato",
    "title": "Registrar Contrato",
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
            "optional": false,
            "field": "nivel",
            "description": "<p>Nivel del nuevo contrato</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:255",
            "optional": false,
            "field": "descripcion",
            "description": "<p>Descripción del nuevo contrato</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:16",
            "optional": true,
            "field": "unidad",
            "description": "<p>Unidad de medida del nuevo contrato</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "size": "max:16",
            "optional": true,
            "field": "cantidad_original",
            "description": "<p>Cantidad del nuevo contrato</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "max:140",
            "optional": true,
            "field": "clave",
            "description": "<p>Clave del nuevo contrato</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "id_marca",
            "description": "<p>Marca del nuevo contrato</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": true,
            "field": "id_modelo",
            "description": "<p>Modelo del nuevo contrato</p>"
          },
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": true,
            "field": "destinos",
            "description": "<p>Destinos del contrato</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "destinos.id_concepto",
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
            "description": "<p>Datos del Contrato</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response",
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": {\n    \"id_concepto\": 1234\n    \"id_transaccion\": 31557\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Api/Controllers/ContratoController.php",
    "groupTitle": "Contrato",
    "name": "PostContrato"
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
