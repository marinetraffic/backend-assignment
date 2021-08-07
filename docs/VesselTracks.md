# Vessels Tracks

## Importing data
1. Upload `ship_positions.json` in root directory
2. On console, run: `php artisan vessels_tracks:import`

## Vessels Tracks GET API 
`/api/vessels_tracks`

### Available filters:
`/api/vessels_tracks?<filter>=value&<filter>=value`

Filters | Description
--- | ---
mmsi | filters single or multiple mmsi
lon | filters exact longitude
lon_from | filters longitude greater than or equal to given value
lon_to | filters longitude less than or equal to given value
lat | filters exact latitude
lat_from | filters latitude greater than or equal to given value
lat_to | filters latitude less than or equal to given value
timestamp | filters exact timestamp
timestamp_from | filters timestamp greater than or equal to given value
timestamp_to | filters timestamp less than or equal to given value

### Supported Content Types
`--header 'Accept: <content_type>'`

Content Types |
--- |
application/json |
application/hal+json |
application/xml | 
text/csv |

