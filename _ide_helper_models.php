<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Auth{
/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $type
 * @property string $signature_path
 * @property string|null $original_filename
 * @property string $mime_type
 * @property int $file_size
 * @property bool $is_default
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Auth\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereOriginalFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereSignaturePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signature whereUserId($value)
 */
	class Signature extends \Eloquent {}
}

namespace App\Models\Auth{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @property string $division
 * @property string $position
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePosition($value)
 * @mixin \Eloquent
 * @property string $role
 * @property int|null $verified_by
 * @property \Carbon\CarbonImmutable|null $verified_at
 * @property bool $is_active
 * @property-read User|null $verifier
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereVerifiedBy($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models\Engineering\ItemDetail{
/**
 * @property int $id
 * @property int $section_id
 * @property string $name
 * @property int $sort_order
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Engineering\ItemDetail\ItemDetail> $itemDetails
 * @property-read int|null $item_details_count
 * @property-read \App\Models\Engineering\ItemDetail\Section $section
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Engineering\ItemDetail\SubCategory> $subCategories
 * @property-read int|null $sub_categories_count
 * @method static \Database\Factories\ProjectControl\ItemDetail\CategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Category extends \Eloquent {}
}

namespace App\Models\Engineering\ItemDetail{
/**
 * @property int $id
 * @property int $section_id
 * @property int|null $category_id
 * @property int|null $sub_category_id
 * @property string $name
 * @property string $unit
 * @property int $sort_order
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read \App\Models\Engineering\ItemDetail\Category|null $category
 * @property-read \App\Models\Engineering\ItemDetail\Section $section
 * @property-read SubCategory|null $subCategory
 * @method static \Database\Factories\ProjectControl\ItemDetail\ItemDetailFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail whereSubCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $scope
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Engineering\PriceList\UnitPrice> $unitPrices
 * @property-read int|null $unit_prices_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail whereScope($value)
 */
	class ItemDetail extends \Eloquent {}
}

namespace App\Models\Engineering\ItemDetail{
/**
 * @property int $id
 * @property string $name
 * @property int $sort_order
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Engineering\ItemDetail\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Engineering\ItemDetail\ItemDetail> $itemDetails
 * @property-read int|null $item_details_count
 * @method static \Database\Factories\ProjectControl\ItemDetail\SectionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Section extends \Eloquent {}
}

namespace App\Models\Engineering\ItemDetail{
/**
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property int $sort_order
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Engineering\ItemDetail\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Engineering\ItemDetail\ItemDetail> $itemDetails
 * @property-read int|null $item_details_count
 * @method static \Database\Factories\ProjectControl\ItemDetail\SubCategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class SubCategory extends \Eloquent {}
}

namespace App\Models\Engineering\PriceList{
/**
 * @property int $id
 * @property string $name
 * @property string $number
 * @property string $client
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Engineering\PriceList\UnitPrice> $unitPrices
 * @property-read int|null $unit_prices_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList whereClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriceList whereUpdatedAt($value)
 */
	class PriceList extends \Eloquent {}
}

namespace App\Models\Engineering\PriceList{
/**
 * @property int $id
 * @property int $unit_price_id
 * @property \Carbon\CarbonImmutable|null $date
 * @property float $price
 * @property string|null $notes
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Engineering\PriceList\UnitPrice $unitPrice
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordPrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordPrice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordPrice whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordPrice whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordPrice wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordPrice whereUnitPriceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordPrice whereUpdatedAt($value)
 */
	class RecordPrice extends \Eloquent {}
}

namespace App\Models\Engineering\PriceList{
/**
 * @property int $id
 * @property int $price_list_id
 * @property int $item_detail_id
 * @property bool $isFreeIssueMaterial
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string $scope
 * @property-read \App\Models\Engineering\ItemDetail\ItemDetail $itemDetail
 * @property-read \App\Models\Engineering\PriceList\RecordPrice|null $latestRecordPrice
 * @property-read \App\Models\Engineering\PriceList\PriceList $priceList
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Engineering\PriceList\RecordPrice> $recordedPrices
 * @property-read int|null $recorded_prices_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UnitPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UnitPrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UnitPrice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UnitPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UnitPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UnitPrice whereIsFreeIssueMaterial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UnitPrice whereItemDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UnitPrice wherePriceListId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UnitPrice whereScope($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UnitPrice whereUpdatedAt($value)
 */
	class UnitPrice extends \Eloquent {}
}

namespace App\Models\ManPower{
/**
 * @property int $id
 * @property string $name
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ManPower\Worker> $workers
 * @property-read int|null $workers_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkScope newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkScope newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkScope query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkScope whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkScope whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkScope whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkScope whereUpdatedAt($value)
 */
	class WorkScope extends \Eloquent {}
}

namespace App\Models\ManPower{
/**
 * @property int $id
 * @property string $id_card_number
 * @property string $name
 * @property string $based
 * @property string $phone_number
 * @property string $email
 * @property string|null $photo
 * @property string $work_status
 * @property string|null $last_follow_up
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ManPower\WorkerCertificate> $certificates
 * @property-read int|null $certificates_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ManPower\WorkScope> $workScopes
 * @property-read int|null $work_scopes_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Worker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Worker newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Worker query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Worker whereBased($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Worker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Worker whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Worker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Worker whereIdCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Worker whereLastFollowUp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Worker whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Worker wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Worker wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Worker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Worker whereWorkStatus($value)
 */
	class Worker extends \Eloquent {}
}

namespace App\Models\ManPower{
/**
 * @property int $id
 * @property int $worker_id
 * @property string $certificate_name
 * @property \Carbon\CarbonImmutable|null $expired_date
 * @property string|null $document_path
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\ManPower\Worker $worker
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkerCertificate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkerCertificate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkerCertificate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkerCertificate whereCertificateName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkerCertificate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkerCertificate whereDocumentPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkerCertificate whereExpiredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkerCertificate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkerCertificate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkerCertificate whereWorkerId($value)
 */
	class WorkerCertificate extends \Eloquent {}
}

namespace App\Models\ProjectControl{
/**
 * @property int $id
 * @property int $project_id
 * @property string $detailed_area
 * @property int $isMultipleCustomer
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectControl\Plans> $plans
 * @property-read int|null $plans_count
 * @property-read Projects $project
 * @method static \Database\Factories\ProjectControl\BoqFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Boq newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Boq newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Boq query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Boq whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Boq whereDetailedArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Boq whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Boq whereIsMultipleCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Boq whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Boq whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Boq extends \Eloquent {}
}

namespace App\Models\ProjectControl{
/**
 * @property int $id
 * @property int $boq_id
 * @property int $unit_price_id
 * @property int|null $plan_category_id
 * @property numeric|null $volume
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\ProjectControl\Boq $boq
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectControl\PlanDetail> $planDetails
 * @property-read int|null $plan_details_count
 * @property-read \App\Models\Engineering\PriceList\UnitPrice $unitPrice
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereBoqId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan wherePlanCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereUnitPriceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereVolume($value)
 */
	class Plan extends \Eloquent {}
}

namespace App\Models\ProjectControl{
/**
 * @property int $id
 * @property string|null $name
 * @property string $scope
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectControl\Plan> $plans
 * @property-read int|null $plans_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanCategory whereScope($value)
 */
	class PlanCategory extends \Eloquent {}
}

namespace App\Models\ProjectControl{
/**
 * @property int $id
 * @property int $plan_id
 * @property string $plan_date
 * @property numeric $plan_volume
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\ProjectControl\Plans $plan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanDetail wherePlanDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanDetail wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanDetail wherePlanVolume($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property numeric $volume
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanDetail whereVolume($value)
 */
	class PlanDetail extends \Eloquent {}
}

namespace App\Models\ProjectControl{
/**
 * @property int $id
 * @property int $boq_id
 * @property int $plan_id
 * @property string|null $date
 * @property numeric|null $volume
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\ProjectControl\Plan $plan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Progress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Progress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Progress query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Progress whereBoqId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Progress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Progress whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Progress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Progress wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Progress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Progress whereVolume($value)
 */
	class Progress extends \Eloquent {}
}

namespace App\Models\Project{
/**
 * @property int $id
 * @property int $project_id
 * @property string $amendment_date
 * @property string $amendment_description
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectAmendment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectAmendment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectAmendment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectAmendment whereAmendmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectAmendment whereAmendmentDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectAmendment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectAmendment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectAmendment whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectAmendment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ProjectAmendment extends \Eloquent {}
}

namespace App\Models\Project{
/**
 * @property int $id
 * @property string $project_name
 * @property string|null $project_code
 * @property string|null $project_number
 * @property string $category
 * @property numeric|null $budget
 * @property string $area
 * @property string $client
 * @property string $start_date
 * @property string $end_date
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string $status
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereBudget($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereProjectCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereProjectName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereProjectNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereUpdatedAt($value)
 * @property int $isMultipleArea
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Boq> $boqs
 * @property-read int|null $boqs_count
 * @method static \Database\Factories\Project\ProjectsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereIsMultipleArea($value)
 * @mixin \Eloquent
 * @property int|null $price_list_id
 * @property-read \App\Models\Engineering\PriceList\PriceList|null $priceList
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects wherePriceListId($value)
 */
	class Projects extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @property string $division
 * @property string $position
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePosition($value)
 * @mixin \Eloquent
 * @property string $role
 * @property int|null $verified_by
 * @property string|null $verified_at
 * @property int $is_active
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereVerifiedBy($value)
 */
	class User extends \Eloquent {}
}

