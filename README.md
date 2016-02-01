# PIM catalogs

## Scalability
- small
- medium
- large

## How to generate?

By using the https://github.com/akeneo-labs/DataGeneratorBundle

## Caution

Please use the relevant branch when using with Akeneo PIM (catalog 1.4 = pim 1.4)

## How to install a catalog

Create a symbolik link to the fixtures

```
ln -s /<path_to_catalog>/scalability/<catalog_size>/fixtures/ /<path_to_ee>/src/PimEnterprise/Bundle/InstallerBundle/Resources/fixtures/<catalog_size>
```

Update the installer catalog in `app/config/pim_parameters.yml`

```
installer_data:       PimEnterpriseInstallerBundle:catalog_size
```

Install the fixtures (don't forget to disable xdebug if enabled)

```
rm -rf app/cache && app/console pim:install --env=prod --force
```

