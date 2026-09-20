---
name: infer-laravel-blueprint
description: "Use when: generating a Laravel Blueprint YAML file from a CSV or JSON dataset, turning a plain-language request into a valid php index.php command, and asking for missing CLI options before running the app for the current project workspace."
---

# Laravel Blueprint Generator

ONLY READ FILES ~/.copilot/skills/infer-laravel-blueprint/src/Console.php and ~/.copilot/skills/infer-laravel-blueprint/SKILL.md.
ONLY EXECUTE the `php` CLI tool. DO NOT use python, composer, or any other CLI tool.
DO NOT READ data files.
DO NOT WRITE OR MODIFY any files yourself.
DO NOT search for files.
The project workspace is the VS Code workspace folder where the user is running the commands.

## Context and Scope

You are operating as a global skill. You must ground all of your responses, logic, and generation in the context of the user's active, open VS Code workspace directory. You will invoke the PHP CLI tool as specified in the command template.

## Command Template

```bash
php index.php <path-or-url> [--db=sqlite|mysql|sqlserver] [--cwd=<current-working-directory>] [--dry-run] [--format=sql,blueprint] [--blueprint-model=<name>] [--blueprint-seeders] [--blueprint-view=blade|inertia] [--blueprint-model-resource=web,api,index,create,store,edit,update,show,destroy,api.index,api.store,api.store,api.update,api.show,api.destroy] [--blueprint-controller-methods=index,create,store,edit,update,show,destroy,api.index,api.store,api.store,api.update,api.show,api.destroy,<custom>] [--save] [--help]
```

## Pre-Execution Steps

Before performing the primary task, you must:

1. Get the root directory of the open project workspace to use as the fully qualified path.
2. Ensure the PHP script's CLI parameters only read files from and save files to the open VS Code workspace folder.

## Purpose

Use the PHP CLI in this repository to transform a CSV or JSON dataset into a Laravel Blueprint YAML file. The skill converts a natural-language request into the correct command, asks for any missing CLI options, and verifies the generated output.

## File Access Boundaries

- Only read the CLI contract in `Console.php`. Do not read any other PHP file and do not read any data source provided to the script.
- If the task requires behavior not described in `Console.php`, inform the user of this limitation and any error message thrown.
- Treat `Console.php` as the single source of truth for supported flags, arguments, and validation rules.

## Required Inputs

The user may provide any of the following in their prompt:

- a local data file path or remote URL to save locally and infer a database schema for.
- The project workspace using this skill as the current working directory parameter.

If the user does not provide a value for an option, ask a short follow-up question before executing the command.

## Workflow

1. Identify the dataset source.
   - If the user provides a file path local to the project workspace, use it as a fully qualified path in the positional argument.
   - If the user provides a URL, use it as-is in the positional argument.
   - If neither is present, ask the user for the CSV or JSON file path or remote URL.

2. Identify the current working directory.
   - The user should not need to provide the --cwd option explicitly; use the project workspace as the default value.

3. Build the command.
   - Use the repo CLI entry point: php index.php
   - Add only the flags that the user provided or that you confirmed.
   - Preserve quoting for file paths and URLs.

4. Run the command and inspect the result.
   - First run the PHP script with the `--dry-run` flag to check for errors or warnings without generating the file.
   - If the command fails, explain the validation error and ask which option should change.
   - If the dry-run succeeds without errors, proceed to run the command with the `--quiet` flag to generate the file.
   - If the generation succeeds, summarize where the YAML was written or what was previewed.

## Decision Points

- If the user wants to use the result to create a Laravel Blueprint blueprint.yaml file to scaffold the Laravel code, then use a Laravel coding agent and your knowledge of the Laravel Blueprint yaml specification to suggest file contents for the yaml file given the database column types and modifiers returned from the PHP CLI command. Then ask the user if they want you to save those contents to a file in their VS Code workspace directory and then run `php artisan blueprint:build <blueprint.yaml>`.

## Quality Bar

- Use the actual CLI contract in `Console.php` and the CLI entry point `index.php`.
- Ask for any missing required option before running the command.
- Prefer a short confirmation step when the request is ambiguous.
- Do not invent undocumented flags.

## Example Prompts

- “Show me the database schema compatible with data.xlsx.”
- “Generate a Blueprint file from data.json for a User model and save it.”
- “Use the CSV at ./data.csv to create a blueprint web resource and preview the YAML.”
- “Fetch https://example.com/users.json and generate it as an Order model.”
- “Create the Blueprint file for my dataset, but ask me any missing options before running it.”
- ”Generate a Blueprint file from https://example.com/users.json as a User model and an Inertia view and then scaffold the Laravel code using the blueprint file.”

## Follow-Up Questions

Ask the user only for the values that are missing. Good examples:

- “Which file or URL should I use as the source data?”
- “Should I use the inferred model name or set a custom one?”
- “What resource type should I generate: api, web, all, or none?”
- “Do you want the YAML previewed in the terminal or written to a file in the repo?”

## Completion Check

The task is complete only when:

- the source dataset is identified,
- all required options are either supplied or confirmed,
- the command reflects the user’s intent,
- the generated Blueprint YAML file or preview is returned to the user,
- and any errors are explained clearly if the generation fails.
