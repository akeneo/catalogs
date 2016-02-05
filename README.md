# PIM catalogs

## From 1.4 to 1.5
- add `ui_locale` to `users.yml`

## Scalability
- small
- medium
- large

## How to generate?

By using the https://github.com/akeneo-labs/DataGeneratorBundle

## Caution

Please use the relevant branch when using with Akeneo PIM (catalog 1.4 = pim 1.4)

## How to install a catalog

To install a catalog, you will have to:

- add the catalog to the `InstallerBundle`
- set your catalog in the PIM parameters
- install the fixtures
- import the products


### Create a symbolik link to the fixtures

For community catalog:
```
ln -s /<path_to_catalog>/<version>/community/<catalog_size>/fixtures/ /<path_to_pim>/src/Pim/Bundle/InstallerBundle/Resources/fixtures/<catalog_size>
```
For enterprise catalog:
```
ln -s /<path_to_catalog>/<version>/enterprise/<catalog_size>/fixtures/ /<path_to_pim>/src/PimEnterprise/Bundle/InstallerBundle/Resources/fixtures/<catalog_size>
```

### Update the installer catalog

For community catalog:
```
sed -i -e 's/\(installer_data: *PimInstallerBundle:\).*$/\1small/g' app/config/pim_parameters.yml
```

For community catalog:
```
sed -i -e 's/\(installer_data: *PimEnterpriseInstallerBundle:\).*$/\1small/g' app/config/pim_parameters.yml
```
### Install the fixtures

Warning! Don't forget to disable xdebug if enabled, and run the commands with prod environment.

```
rm -rf app/cache && app/console pim:install --env=prod --force
```

### Install the products

The catalog don't include products in fixtures, you need to import in after fixtures:
```
gunzip -c /<path_to_catalog>/<community|enterprise>/<catalog_size>/products.csv.gz > /tmp/product.csv
app/console akeneo:batch:job csv_product_import --env=prod
```
