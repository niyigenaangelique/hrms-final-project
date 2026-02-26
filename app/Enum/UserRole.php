<?php

namespace App\Enum;

enum UserRole: string
{
    /** System-wide administrator with all permissions across all companies. */
    case SuperAdmin = 'SuperAdmin';

    /** Company-wide administrator with permissions for a specific company. */
    case CompanyAdmin = 'CompanyAdmin';

    /** System-wide data master with all permissions across all companies. */
    case DataMaster = 'DataMaster';

    /** Company data master with permissions for a specific company. */
    case CompanyDataMaster = 'CompanyDataMaster';

    /** Operations manager overseeing operations at a specific company. */
    case OperationsManager = 'OperationsManager';

    /** HR administrator for a specific company, managing HR settings and users. */
    case HRAdmin = 'HRAdmin';

    /** HR manager responsible for overseeing HR activities within a specific company. */
    case HRManager = 'HRManager';

    /** HR officer handling recruitment, attendance, and payroll for a specific company. */
    case HROfficer = 'HROfficer';

    /** Payroll officer managing salaries, taxes, and payslips for a specific company. */
    case PayrollOfficer = 'PayrollOfficer';
    case HRClark = 'HRClark';

    /** Employee of a specific company with access to self-service features. */
    case Employee = 'Employee';

    /** Finance administrator managing financial operations across the company. */
    case FinanceAdmin = 'FinanceAdmin';

    /** Finance manager responsible for budgeting, forecasting, and reporting. */
    case FinanceManager = 'FinanceManager';

    /** Finance officer handling transactions, accounts, and expense tracking. */
    case FinanceOfficer = 'FinanceOfficer';

    /** Supervisor monitoring attendance and performance at a specific site. */
    case SiteSupervisor = 'SiteSupervisor';

    /** Administrator for a specific site, managing site-level HR operations and resources. */
    case SiteAdmin = 'SiteAdmin';

    /** Manager responsible for overseeing all HR and finance activities at a site level. */
    case SiteManager = 'SiteManager';

    /** Project manager overseeing projects and staffing within a specific company or site. */
    case ProjectManager = 'ProjectManager';

    /** Management manager responsible for overseeing HR and finance activities at a company level. */
    case LeadershipTeamMember = 'LeadershipTeamMember';

    /** Employee of a specific site with access to self-service features. */
    case SiteEmployee = 'SiteEmployee';

    /**
     * Get the human-readable description for the role.
     */
    public function description(): string
    {
        return match ($this) {
            self::SuperAdmin => 'System-wide administrator with all permissions across all projects.',
            self::CompanyAdmin => 'Project-wide administrator with permissions for a specific project.',
            self::LeadershipTeamMember => 'Management manager responsible for overseeing HR and finance activities at a project level.',
            self::OperationsManager => 'Project operations manager responsible for overseeing HR and finance activities at a project level.',
            self::FinanceManager => 'Finance manager responsible for budgeting, forecasting, and reporting.',
            self::HRManager => 'HR manager responsible for overseeing HR activities within a specific project.',
            self::SiteManager => 'Manager responsible for overseeing all HR and finance activities at a site level.',
            self::ProjectManager => 'Project manager overseeing projects and staffing within a specific project or site.',
            self::HRAdmin => 'HR administrator for a specific project, managing HR settings and users.',
            self::HROfficer => 'HR officer handling recruitment, attendance, and payroll for a specific project.',
            self::HRClark => 'HR officer handling data entry, attendance, and payroll for a specific project.',
            self::PayrollOfficer => 'Payroll officer managing salaries, taxes, and payslips for a specific project.',
            self::Employee => 'Employee of a specific project with access to self-service features.',
            self::FinanceAdmin => 'Finance administrator managing financial operations across the project.',
            self::FinanceOfficer => 'Finance officer handling transactions, accounts, and expense tracking.',
            self::SiteSupervisor => 'Supervisor monitoring attendance and performance at a specific site.',
            self::SiteAdmin => 'Administrator for a specific site, managing site-level HR operations and resources.',
            self::SiteEmployee => 'Employee of a specific site with access to self-service features.',
            self::DataMaster => 'System-wide data master with all permissions across all projects.',
            self::CompanyDataMaster => 'Project data master with permissions for a specific project.',
        };
    }



    /**
     * Get all enum values as an array.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
    /**
     * Get all the enum values as an array
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all the enum names as an array
     */
    public static function getNames(): array
    {
        return array_column(self::cases(), 'name');
    }
    public static function caseWithDescriptions(): array
    {
        return array_map(fn($case) => [
            'value' => $case->value,
            'description' => $case->description(),
        ], self::cases());
    }

    /**
     * Returns an associative array suitable for <select> dropdowns.
     *
     * @return array<string>
     */
    public static function forSelect(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($status) => [$status->value => $status->name])
            ->all();
    }
    public static function detailedList(): array
    {
        return array_map(fn($case) => [
            'key' => $case->value,
            'label' => ucwords(str_replace('_', ' ', preg_replace('/(?<!^)[A-Z]/', ' $0', $case->value))),
            'description' => $case->description(),
        ], self::cases());
    }

}

