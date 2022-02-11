const Encore = require("@symfony/webpack-encore");

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || "dev");
}

Encore
  // directory where compiled assets will be stored
  .setOutputPath("public/build/")
  // public path used by the web server to access the output path
  .setPublicPath("/build")
  // only needed for CDN's or sub-directory deploy
  //.setManifestKeyPrefix('build/')

  /*
   * ENTRY CONFIG
   *
   * Each entry will result in one JavaScript file (e.g. app.js)
   * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
   */
  .addEntry("app", "./assets/app.js")
  .addEntry("home", "./assets/home.js")
  .addEntry("form", "./assets/form.js")
  .addEntry("formCategory", "./assets/categoryForm.js")
  .addEntry("admin", "./assets/adminapp.js")
  .addEntry("admin_index", "./assets/adminindex.js")
  .addEntry("bande", "./assets/bande.js")
  .addEntry("contact", "./assets/contact.js")
  .addEntry("category", "./assets/category.js")
  .addEntry("marque", "./assets/marque.js")
  .addEntry("produitQuery", "./assets/produitQuery.js")
  .addEntry("basket", "./assets/basket.js")
  .addEntry("addbasket", "./assets/addbasket.js")
  .addEntry("product", "./assets/product.js")
  .addEntry("products", "./assets/products.js")
  .addEntry("profile", "./assets/profile.js")
  .addEntry("parameters", "./assets/parameters.js")
  .addEntry("connexion", "./assets/connexion.js")
  .addEntry("inscription", "./assets/inscription.js")
  .addEntry("command", "./assets/command.js")
  .addEntry("admin_command_consult", "./assets/admin_command_consult.js")
  .addEntry("user_consult", "./assets/user_consult.js")
  .addEntry("design", "./assets/design.js")
  .addEntry("article", "./assets/article.js")
  .addEntry("oneArticle", "./assets/oneArticle.js")
  .addEntry("formadd", "./assets/formadd.js")
  .addEntry("graphHome", "./assets/graphHome.js")
  .addEntry("aboutUs", "./assets/aboutUs.js")
  .addEntry("passwordRequest", "./assets/passwordRequest.js")
  // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
  // .enableStimulusBridge('./assets/controllers.json')

  // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
  .splitEntryChunks()

  // will require an extra script tag for runtime.js
  // but, you probably want this, unless you're building a single-page app
  .enableSingleRuntimeChunk()

  /*
   * FEATURE CONFIG
   *
   * Enable & configure other features below. For a full
   * list of features, see:
   * https://symfony.com/doc/current/frontend.html#adding-more-features
   */
  .cleanupOutputBeforeBuild()
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  // enables hashed filenames (e.g. app.abc123.css)
  .enableVersioning(Encore.isProduction())

  .configureBabel((config) => {
    config.plugins.push("@babel/plugin-proposal-class-properties");
  })

  // enables @babel/preset-env polyfills
  .configureBabelPresetEnv((config) => {
    config.useBuiltIns = "usage";
    config.corejs = 3;
  });

// enables Sass/SCSS support
//.enableSassLoader()

// uncomment if you use TypeScript
//.enableTypeScriptLoader()

// uncomment if you use React
//.enableReactPreset()

// uncomment to get integrity="..." attributes on your script & link tags
// requires WebpackEncoreBundle 1.4 or higher
//.enableIntegrityHashes(Encore.isProduction())

// uncomment if you're having problems with a jQuery plugin
//.autoProvidejQuery()

module.exports = Encore.getWebpackConfig();
