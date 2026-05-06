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