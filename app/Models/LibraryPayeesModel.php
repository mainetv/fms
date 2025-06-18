<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

class LibraryPayeesModel extends Model implements Auditable
{
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    public $fillable = [
        'parent_id',
        'payee_type_id',
        'organization_type_id',
        'payee',
        'previously_named',
        'organization_name',
        'organization_acronym',
        'title',
        'last_name',
        'first_name',
        'middle_initial',
        'suffix',
        'tin',
        'bank_id',
        'bank_branch',
        'bank_account_name',
        'bank_account_name1',
        'bank_account_name2',
        'bank_account_no',
        'address',
        'office_address',
        'email_address',
        'contact_no',
        'is_verified',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'library_payees';

    public function payeeType(): BelongsTo
    {
        return $this->belongsTo(LibraryPayeeTypeModel::class, 'payee_type_id');
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(LibraryBanksModel::class, 'bank_id');
    }

    public function rsRecords(): HasMany
    {
        return $this->hasMany(RSModel::class, 'payee_id'); // Ensure correct foreign key
    }

    public function dvRecords(): HasMany
    {
        return $this->hasMany(DVModel::class, 'payee_id'); // Ensure correct foreign key
    }

    public function getPayeeWasUsedAttribute(): bool
    {
        return $this->rsRecords()->exists() || $this->dvRecords()->exists();
    }
}
