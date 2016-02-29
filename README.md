# PIM catalogs

## Upgrade catalogs notes

  1.3  |&#10596;                     |   1.4  |&#10596;                       |  1.5   |&#10596;|  master
-------|--------------------------------------|-------------------------------|---------------------------------------|--------|--------|----------
CE 1.3 |remove `owner` to `users.yml`| CE 1.4 | add `ui_locale` to `users.yml`| CE 1.5 |nothing to do| CE master  
EE 1.3 |                             | EE 1.4 | add `ui_locale` to `users.yml`, add `proposals_to_review_notification: true` to `users.yml`, add `proposals_state_notifications: true` to `users.yml`| EE 1.5 |nothing to do| EE master  

## Are catalogs up-to-date since last configuration change of the DataGeneratorBundle?

Version | Community | Enterprise
--------|-----------|-----------
1.3     | N         | N
1.4     | N         | Y
1.5     | small and medium Y, large N         | N
master  | N         | N

## How to generate a catalog?

By using the https://github.com/akeneo-labs/DataGeneratorBundle

## How to install a catalog?

To install a catalog, you will have to:

- `composer require "akeneo/catalogs":"dev-master"` 
- set your catalog in the PIM parameters via `installer_data: vendor/akeneo/catalogs/path/to/the/catalog/fixtures`
- install the fixtures `rm -rf app/cache && app/console pim:install --env=prod --force`
- import the products 
```
gunzip -c /<path_to_catalog>/<community|enterprise>/<catalog_size>/products.csv.gz > /tmp/product.csv
app/console akeneo:batch:job csv_product_import --env=prod
```

