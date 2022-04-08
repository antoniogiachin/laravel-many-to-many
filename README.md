# Passi da compiere - Progetto con front-end (vue) e back-end (laravel - bootstrap per pannello amministrativo) - simil WordPress.

## Installazione componenti
- Installare laravel/ui *composer require laravel/ui:^2.4*
- Scaffolding con **auth** per Vue *php artisan ui vue --aut*
- In package.json metto versione di bootstrap a 5
- lancio istallazione con *npm install*

## Gestione rotte sottoposte a middleware::auth
- Rimozione **HomeController** di Laravel -> voglio il mio controller sotto la cartella(namespace) Admin
- Creo cartella(namespace) Admin sotto controllers
- *php artisan make:controller Admin/HomeController* -> crea controller sotto la cartella/namespace Admin
- Imposto nel file web.php, le rotte affinché esse siano accessibili solo a chi si autentica(usando middleware('auth')) ->vedi file web.php
- Dopo il login Laravel rediretta alla rotta /home, noi vogliamo che dopo il login siamo redirettati ad /admin/, possiamo cambiare la cosa in **app/Providers/RouteServiceProvider.php*

## Gestione HomeController
- Prelevo i dati inseriti dall'utente e li passo alla vista admin.home (che creo in view sotto la cartella Admin), attraverso il model Auth -> Auth::user(), essendo un *facades* va inserito sul controller *use Illuminate\Support\Facades\Auth;*
- Creo la view home.blade.php sotto la cartella Admin, assieme ad una ulteriore sottocartella admin/layouts con il layout di base (che copio da quello già presente)
- Allo stesso modo copio home da quello già presente fuori Admin

## DB Side
- Per quanto riguarda User -> pensa a tutto Laravel, mi basta lanciare la migration

## Gestisco scaffoldiing Front-End di Vue
Mi serve impostare delle rotte: in particolare voglio che tutto ciò che non è intercettqto dalle precedenti (quelle relative all'admin o altro) mi rimandi ad una rotta guest.home
- Imposto la rotta generica per guest.home -> vedi web.php
- Sottocartella view guest-> qui finisce tutto ciò che è gestito front-end, cominciando da home.blade.php
- Creo il component App.vue che contiene tutto il vue di cui il sito ha bisogno -> dentro resources/js/components
- Faccio la import della App.vue in un file JS dedicato al front nello specifico -> dentro resources/js -> guarda il file per vedere come istanziare
- Cancello tutto il contenuto (eccetto bootstrap) del file app.js base (lo uso solo per il backend), e nel webpack.mix.js inserisco anche il front.js
- Nella home di Guest metto lo script per il front.js e il tag div #root, poi rilancio npm run watch/serve

## Gestiamo inserimento post nel DB
- Creiamo table posts  *php artisan make:migration create_posts_table*
- Creiamo controller Crud per i post *php artisan make:controller --resource Admin/PostController* sotto la cartella Admin
- Creo model per i Post *php artisan make:model Post*
- Definisco la tabella nella migration, nei campi con **slug** intendo una stringa che va ad identificare il post nell'url relativo: ad esempio miosito.it/slug, lo slug è unique
- Faccio migration
- Imposto nel model di Post i campi fillable
- TODO

## Gestione rotte PostController e views post
- Route::resource nel file web.php, essendo rotte accessibili solo se admin finiscono all'interno del gruppo di admin
- PostController -> funzione index() mi ritorna index dei post -> nuova cartella post in admin con le varie viste dei post
- Funzione index() PostController -> preleva tutti i post dal DB e li invia compact alla index dei post
- Layout base modificato-> inseriti nella nav collegamento a dashboard(admin.home) e alla tabella dei post (admin.post.index)
- Inserita tabella in admin.post.index e pulsante per admin.post.create
- Form per creazione in admin.post.create -> inserimento {{old}} nel form create
- Inserimento validazioni nello store - e flash message dell'errore - prelievo dati dal form e inserisco in data
- gestisco lo slug da inserire dentro data
- fill di $post con $data e redirect sulla show con post creato -> creo la view post.show e la gestisco nel controller dei post
- Gestisco controller e viste per edit e update
- Gestico destroy/delete

## Creazione tabella categorie
- *php artisan make:migration create_categories_table*
- e effettuo migrazione
- creo model e faccio seed *php artisan db:seed --class=CategoryTableSeeder*

## Collego le due tabelle posts e categories
La relazione è di uno (categoies) a molti (posts). La tabella dipendente è dunque post che conterrà la foreignkey
- Per aggiungerla faccio un update della migration tabella posts, da documentazione il comando artisan *php artisan make:migration add_votes_to_users_table --table=users* -> il mio sarà *php artisan make:migration add_foreign_key_to_posts_table --table=posts* ->vai al file per i passaggi
- Mi occupo dei model per le due tabelle e li collego ->creo model category

## Refactoring per le viste con la categoria
- Create, Edit

## 08 Aprile

### Creazione e gestione tabella tags
- Creazione tabella tags solito procedimento, migration
- Creazione model Tag
- Popolo tabella tag con Seeder

### Gestione relazione many to many posts-tags
- relazione definita nei model post e tag
- creazione migration tabella model *php artisan make:migration create_post_tag_table*
- All'interno della migration pivot, tolgo i $table originari e inserisco le due chiavi provenienti da post e tag per relazione -> aggiungo anche indice che tenga traccia dei due id in coppia

### Gestione Post aggiunta dei tag
- Gestione create -> post controller -> recupero tutti i tags e li passo alla vista
- Gestione create -> nella vista preparo la checkbox con i tags
- Gestione store -> postController ->validazioni
- Gestione store -> postController -> faccio sync
- Visualizzo in post.index e post.show  anche i tag -> utilizzando in blade la funzione tags presente nel model di post.
- Gestione edit -> passo ad edit i tags
- Gestione update

## Gestione rotte dei tags
- Creo controller dei tags *php artisan make:controller --resource Admin/TagController*
- gestisco rotte in web.php e aggiungo rotta per i tags nella navbar in layouts
- gestisco show e index tag