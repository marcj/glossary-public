## Welcome to Spryker Glossary Bundle

[Spryker](http://spryker.com) is an E-commerce framework. As the name framework suggests, it includes everything to build modern E-commerce sites. It's designed from the ground up to easily extend or exchange parts of the framework in order to adapt to the projects requirements. Another concept is the separation of frontend and backend. The frontend, called Yves, is fast and lightweight. The backend, called Zed, contains all business logic. This is why you will see folders like [SprykerFeature/Zed](vendor/spryker/zed-package/src/SprykerFeature/Zed) in this repository.

### Spryker Framework Code
Spryker is divided into functional units called bundles. For example there is a product-bundle, discount-bundle and glossary-bundle. The glossary-bundle, you are currently looking at, deals with storing localized strings. This functionality can be used by other bundles e.g. the cms-bundle.

Bundle dependencies are managed and installed by [composer](http://getcomposer.org). They are installed into [vendor/spryker](vendor/spryker).

#### Layers
Each bundle consists of up to 4 layers.

* The [Presentation Layer](vendor/spryker/zed-package/src/SprykerFeature/Zed/Glossary/Presentation) contains only templates. We use [Twig](http://twig.sensiolabs.org) as a template engine. For the Glossary-bundle you will find [glossary-keys-grid.twig](vendor/spryker/zed-package/src/SprykerFeature/Zed/Glossary/Presentation/Grid/glossary-keys-grid.twig) which contains the backend UI for managing glossary entries.

* The [Communication Layer](vendor/spryker/zed-package/src/SprykerFeature/Zed/Glossary/Communication) handles all sorts of communication. Like a typical web [Controller](vendor/spryker/zed-package/src/SprykerFeature/Zed/Glossary/Communication/Controller/FormController.php) and [Form](vendor/spryker/zed-package/src/SprykerFeature/Zed/Glossary/Communication/Form/TranslationForm.php). But also [Plugins](src/Pyz/Zed/Glossary/Business/Internal/DemoData/GlossaryInstall.php) to communicate with other bundles.

* The [Business Layer](vendor/spryker/zed-package/src/SprykerFeature/Zed/Glossary/Business) contains all business logic specific to this bundle. In case of the glossary-bundle it handles the management of glossary keys and translations. It also provides a [GlossaryFacade.php](vendor/spryker/zed-package/src/SprykerFeature/Zed/Glossary/Business/GlossaryFacade.php) for other bundles that depend on the glossary-bundle, e.g. a cms-bundle.

* The [Persistence Layer](vendor/spryker/zed-package/src/SprykerFeature/Zed/Glossary/Persistence) contains access to storage and queries that retrieve data. We use [Propel](http://propelorm.org) as an object-relational mapper.

#### Dependency Injection
To avoid coupling between the communication, business and persistence layer, every layer has its [dependency container](vendor/spryker/zed-package/src/SprykerFeature/Zed/Glossary/Communication/GlossaryDependencyContainer.php). In order to access another layer, e.g. the business layer wants to retrieve queries from the persistence layer, you have to go through the dependency container. Also, within a layer, every object is created by a factory inside the dependency container. This way you can even replace parts within a layer.

External dependencies to other bundles are implemented via interfaces inside the [Dependency Folder](vendor/spryker/zed-package/src/SprykerFeature/Zed/Glossary/Dependency). So you can see on which other bundles the glossary-bundle depends.

### Project Code
All project related code is located in [src/demoshop]. This is the place where you work in a project. All shop frontend templates and customizations for the shop backend will be here.

If you have to extend framework bundles or configure them, the only thing you have to do is mirror the bundle directory structure. In this repository there is only an [installer](src/Pyz/Zed/Glossary/Communication/Plugin/YamlInstallerPlugin.php). It provides a good intro on how to use a facade of a bundle on the project level.
