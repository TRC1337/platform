<?php declare(strict_types=1);

namespace Shopware\Core\Framework\Event\EventAction;

use Shopware\Core\Content\Rule\RuleDefinition;
use Shopware\Core\Framework\Api\Context\SalesChannelApiSource;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\CascadeDelete;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ReadProtected;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\JsonField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\Event\EventAction\Aggregate\EventActionRule\EventActionRuleDefinition;

class EventActionDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'event_action';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return EventActionCollection::class;
    }

    public function getEntityClass(): string
    {
        return EventActionEntity::class;
    }

    public function getDefaults(): array
    {
        $defaults = parent::getDefaults();

        return array_merge($defaults, [
            'active' => true,
        ]);
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
            (new StringField('event_name', 'eventName', 500))->addFlags(new Required()),
            (new StringField('action_name', 'actionName', 500))->addFlags(new Required()),
            new BoolField('active', 'active'),
            new JsonField('config', 'config'),
            (new ManyToManyAssociationField('rules', RuleDefinition::class, EventActionRuleDefinition::class, 'event_action_id', 'rule_id'))
                ->addFlags(new CascadeDelete(), new ReadProtected(SalesChannelApiSource::class)),
        ]);
    }
}
