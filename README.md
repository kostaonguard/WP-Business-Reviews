# WP-Business-Reviews

## Local Development

Create a new WordPress site at `wpbr-development.dev`.

`cd` into your local `plugins` directory.
```
cd ~/User/Sites/wpbr-development.dev/wp-content/plugins
```

Clone the `develop` branch of this repository.
```
git clone -b develop https://github.com/WordImpress/WP-Business-Reviews-Core.git wp-business-reviews
```

Run composer to set up PHP code sniffing.
```
composer install
```

[Install Yarn](https://yarnpkg.com/en/docs/install) if you have not already. Test that Yarn is installed by running:
```
yarn --version
```

Install npm packages.
```
yarn install
```

Activate the plugin in WordPress.

Launch site via browsersync which will watch for changes.
```
yarn watch
```

### Alpha Preview

The `alpha` branch is used for internal review prior to launching the Beta. It will be updated less frequently than the `develop` branch as features are completed.
```
git checkout -b alpha origin/alpha
```
