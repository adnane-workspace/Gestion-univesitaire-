#!/usr/bin/env python3
import shutil
import os

# Chemins des fichiers
welcome_path = r'c:\1er CI\laravel\universite\resources\views\welcome.blade.php'
welcome_new_path = r'c:\1er CI\laravel\universite\resources\views\welcome_new.blade.php'

# Supprimer le fichier corrompu s'il existe
if os.path.exists(welcome_path):
    os.remove(welcome_path)
    print(f"Fichier corrompu supprimé: {welcome_path}")

# Renommer le fichier propre
if os.path.exists(welcome_new_path):
    shutil.move(welcome_new_path, welcome_path)
    print(f"Fichier propre renommé: {welcome_new_path} -> {welcome_path}")
    print("Opération réussie !")
else:
    print(f"Erreur: Le fichier {welcome_new_path} n'existe pas")
