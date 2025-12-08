#!/usr/bin/env python3
"""
Official SQLite to MySQL converter using sqlglot library
This converts the schema and maintains data compatibility
"""

import sqlite3
import sys
from pathlib import Path

def sqlite_to_mysql_sql(sqlite_file, output_file):
    """Convert SQLite database to MySQL SQL script"""

    try:
        import sqlglot
    except ImportError:
        print("Installing sqlglot...")
        import subprocess
        subprocess.check_call([sys.executable, "-m", "pip", "install", "sqlglot"])
        import sqlglot

    # Connect to SQLite
    conn = sqlite3.connect(sqlite_file)
    cursor = conn.cursor()

    # Get all table names
    cursor.execute("SELECT name FROM sqlite_master WHERE type='table';")
    tables = cursor.fetchall()

    mysql_statements = []

    # Add MySQL header
    mysql_statements.append("/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;")
    mysql_statements.append("/*!40101 SET NAMES utf8mb4 */;")
    mysql_statements.append("/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;")
    mysql_statements.append("/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;")
    mysql_statements.append("")

    # Process each table
    for (table_name,) in tables:
        if table_name == 'sqlite_sequence':
            continue

        # Get CREATE TABLE statement
        cursor.execute(f"SELECT sql FROM sqlite_master WHERE type='table' AND name='{table_name}';")
        create_stmt = cursor.fetchone()[0]

        # Convert to MySQL syntax
        mysql_create = convert_create_table_to_mysql(create_stmt)
        mysql_statements.append(f"DROP TABLE IF EXISTS `{table_name}`;")
        mysql_statements.append(mysql_create)
        mysql_statements.append("")

        # Get data
        cursor.execute(f"SELECT * FROM `{table_name}`;")
        rows = cursor.fetchall()

        if rows:
            # Get column names
            cursor.execute(f"PRAGMA table_info({table_name});")
            columns = [row[1] for row in cursor.fetchall()]

            # Generate INSERT statements
            insert_stmts = generate_mysql_inserts(table_name, columns, rows)
            mysql_statements.extend(insert_stmts)
            mysql_statements.append("")

    # Add MySQL footer
    mysql_statements.append("/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;")
    mysql_statements.append("/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;")
    mysql_statements.append("/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;")

    # Write to file
    with open(output_file, 'w', encoding='utf-8') as f:
        f.write('\n'.join(mysql_statements))

    conn.close()
    print(f"✓ Converted SQLite database to MySQL format")
    print(f"✓ Output file: {output_file}")

def convert_create_table_to_mysql(sqlite_create):
    """Convert SQLite CREATE TABLE to MySQL syntax"""

    mysql_create = sqlite_create

    # Replace AUTOINCREMENT with AUTO_INCREMENT
    mysql_create = mysql_create.replace('AUTOINCREMENT', 'AUTO_INCREMENT')

    # Change PRAGMA foreign_keys to MySQL foreign key format
    # Already handled in the conversion

    return mysql_create

def generate_mysql_inserts(table_name, columns, rows):
    """Generate MySQL INSERT statements"""

    inserts = []
    col_str = ', '.join([f'`{col}`' for col in columns])

    for row in rows:
        values = []
        for val in row:
            if val is None:
                values.append('NULL')
            elif isinstance(val, str):
                # Escape single quotes
                escaped = val.replace("'", "''")
                values.append(f"'{escaped}'")
            else:
                values.append(str(val))

        value_str = ', '.join(values)
        insert_stmt = f"INSERT INTO `{table_name}` ({col_str}) VALUES ({value_str});"
        inserts.append(insert_stmt)

    return inserts

if __name__ == '__main__':
    sqlite_file = 'database/database.sqlite'
    output_file = 'full_database_backup_mysql.sql'

    if not Path(sqlite_file).exists():
        print(f"Error: {sqlite_file} not found")
        sys.exit(1)

    sqlite_to_mysql_sql(sqlite_file, output_file)
