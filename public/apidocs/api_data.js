define({ "api": [
  {
    "type": "post",
    "url": "/sucursal",
    "title": "Registrar Sucursa",
    "version": "1.0.0",
    "group": "Sucursal",
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
            "size": "..255",
            "optional": true,
            "field": "ciudad",
            "description": "<p>Ciudad de la Sucursal</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "..255",
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
            "size": "..255",
            "optional": true,
            "field": "telefono",
            "description": "<p>Teléfono de la Sucursal</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "..255",
            "optional": true,
            "field": "fax",
            "description": "<p>FAX de la Sucursal</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "..255",
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
            "size": "..50",
            "optional": true,
            "field": "email",
            "description": "<p>Email de la Sucursal</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "..50",
            "optional": true,
            "field": "cargo",
            "description": "<p>Cargo de la Sucursal</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "..50",
            "optional": true,
            "field": "telefono_movil",
            "description": "<p>Teléfono Móvil de la Sucursal</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "size": "..500",
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
          "title": "Error-Response:",
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
          "content": "HTTP/1.1 200 OK\n{\n  \"data\": {\n    \"id_sucursal\": \"123\",\n    \"id_empresa\": \"123\",\n    \"descripcion\": \"Descripción\",\n    \"UsuarioRegistro\": \"0001\",\n    \"FechaHoraRegistro\": \"2000-01-01 12:00:00\"\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Api/Controllers/SucursalController.php",
    "groupTitle": "Sucursal",
    "name": "PostSucursal"
  }
] });
