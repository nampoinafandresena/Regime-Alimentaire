base
Table
- User(id, nom, email, genre, date_de_naissance, password)
- UserConfig(id, id_user, taille, poids, portefeuille )
- Code(id, code, montant)
- CodeUser(id, id_code, id_user)
- Regime(id, duree, %viande, %poisson, %volaille, variation_poids, prix)
- Sport(id, libelle, %variation_poids_par_seance)

5 users
15 codes
5 regimes
5 activites
=> repas dans une journee: 100% , regime : 35% de viande, 55%volaille, 10%volaille


inscription: S inscrire => create user 
-> config: Entrer mes donnees => create config_user 
-> home:
    - IMC 
    - mettre a jour mes donnees
    - objectifs: + / - / =




 
👤 Harena : Le spécialiste Santé & ExportAprès avoir fini les modèles et l'inscription, tu peux te charger de la partie "Données de santé".  Complétion du Profil : Gérer la deuxième page de l'inscription (santé : taille, poids) et le calcul automatique de l'IMC à l'affichage.  Porte-monnaie (Côté User) : Créer la vue où l'utilisateur entre son code pour rajouter de l'argent.  Export PDF : Intégrer une bibliothèque (comme Dompdf) pour permettre à l'utilisateur d'exporter son programme de régime et de sport.  
👤 Nampoina : Le garant du Back-Office & PortefeuillePuisque tu as déjà géré la base de données et le template, tu es le mieux placé pour les interfaces d'administration.  Back-Office (CRUD) : Créer les pages pour ajouter/modifier les régimes (avec les % viande, poisson, volaille) et les activités sportives.  Validation des Codes : Créer l'interface permettant à l'admin de voir les codes saisis par les utilisateurs et de les valider pour créditer leur portefeuille.  Statistiques (Dashboard Admin) : Mettre en place le tableau de bord avec des graphiques (utilisation de Chart.js par exemple) et des tableaux croisés sur les revenus et les utilisateurs. 
👤 Tendry : Le cerveau de l'Algorithme & Option GoldTon rôle sera de faire le lien entre les objectifs et les résultats.  L'Algorithme de Suggestion : C'est la tâche critique. Créer la logique qui sélectionne le régime et le sport idéal selon l'objectif choisi (Poids +/- ou IMC idéal) sur une durée précise.  Système Gold : Implémenter l'achat de l'option Gold et s'assurer que la remise de 15% est bien déduite des prix affichés pour ces utilisateurs.  Finalisation des Routes & Merges : S'assurer que toutes les fonctionnalités communiquent bien et gérer les derniers merge vers la branche Main.  
