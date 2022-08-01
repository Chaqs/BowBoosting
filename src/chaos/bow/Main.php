<?php
namespace chaos\bow;
use pocketmine\entity\animation\HurtAnimation;
use pocketmine\entity\projectile\Arrow;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\math\Vector3;

class Main extends PluginBase implements Listener{

    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function bowBoost(EntityShootBowEvent $event)
    {
        $entity = $event->getEntity();
        $arrow = $event->getProjectile();
        $power = $event->getForce();

        if ($entity instanceof Player and $arrow instanceof Arrow) {
            if ($entity->getPosition()->getY() > 30) {
                if ($power <= 0.8 and $entity->getMovementSpeed() !== 0.0) {
                    $entity->setMotion($entity->getDirectionVector()->multiply(1.2));
                    $entity->broadcastAnimation(new HurtAnimation($entity));
                    $arrow->kill();
                    if ($entity->getHealth() > 1.0) {
                        $entity->setHealth($entity->getHealth() - 1.0);
                    }
                } elseif (($power <= 0.8) and $entity->getMovementSpeed() !== 0.0) {
                    $arrow->kill();
                }
            }
        }
    }
}
