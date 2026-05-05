with open(r'c:\1er CI\laravel\universite\resources\views\welcome.blade.php', 'r', encoding='utf-8') as f:
    lines = f.readlines()[:92]
with open(r'c:\1er CI\laravel\universite\resources\views\welcome.blade.php', 'w', encoding='utf-8') as f:
    f.writelines(lines)
print("File truncated successfully")
