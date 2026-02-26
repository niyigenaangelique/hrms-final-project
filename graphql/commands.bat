@echo off
setlocal enabledelayedexpansion

rem List of folders to create
set folders=user comment note project project_user device position employee contract bank bank_info attendance authorized_overtime payroll_month payroll_entry payslip_entry authentication

rem Loop through each folder name
for %%f in (%folders%) do (
    if not exist "%%f" (
        echo Creating folder: %%f
        mkdir "%%f"
    ) else (
        echo Skipping existing folder: %%f
    )

    echo Checking files in %%f...
    if not exist "%%f\inputs.graphql" (
        echo. > "%%f\inputs.graphql"
        echo Created inputs.graphql in %%f
    ) else (
        echo Skipped existing inputs.graphql in %%f
    )
    if not exist "%%f\mutations.graphql" (
        echo. > "%%f\mutations.graphql"
        echo Created mutations.graphql in %%f
    ) else (
        echo Skipped existing mutations.graphql in %%f
    )
    if not exist "%%f\queries.graphql" (
        echo. > "%%f\queries.graphql"
        echo Created queries.graphql in %%f
    ) else (
        echo Skipped existing queries.graphql in %%f
    )
    if not exist "%%f\types.graphql" (
        echo. > "%%f\types.graphql"
        echo Created types.graphql in %%f
    ) else (
        echo Skipped existing types.graphql in %%f
    )
    if not exist "%%f\subscriptions.graphql" (
        echo. > "%%f\subscriptions.graphql"
        echo Created subscriptions.graphql in %%f
    ) else (
        echo Skipped existing subscriptions.graphql in %%f
    )
)

echo.
echo Folder and file creation process completed!
pause
