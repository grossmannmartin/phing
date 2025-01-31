<?php

namespace Phing\Test\Task\Optional;

use Phing\Io\File;
use Phing\Project;
use Phing\Task\Optional\NotifySendTask;
use Phing\Test\Support\BuildFileTest;

/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information please see
 * <http://phing.info>.
 *
 * @internal
 */
class NotifySendTaskTest extends BuildFileTest
{
    protected $object;

    public function setUp(): void
    {
        $this->configureProject(PHING_TEST_BASE . '/etc/tasks/ext/NotifySendTaskTest.xml');
        $this->object = new NotifySendTask();
    }

    public function testEmptyMessage(): void
    {
        $this->executeTarget('testEmptyMessage');
        $this->assertInLogs('cmd: notify-send -i info Phing');
        $this->assertInLogs("Message: ''", Project::MSG_DEBUG);
        // Assert/ensure the silent attribute has been set.
        $this->assertInLogs('Silent flag set; not executing', Project::MSG_DEBUG);
    }

    public function testSettingTitle(): void
    {
        $this->object->setTitle('Test');
        $this->assertEquals('Test', $this->object->getTitle());
        $this->object->setTitle('Test Again');
        $this->assertEquals('Test Again', $this->object->getTitle());
    }

    public function testSettingMsg(): void
    {
        $this->object->setMsg('Test');
        $this->assertEquals('Test', $this->object->getMsg());
        $this->object->setMsg('Test Again');
        $this->assertEquals('Test Again', $this->object->getMsg());
    }

    public function testSetStandardIcon(): void
    {
        $this->object->setIcon(new File('info'));
        $this->assertEquals('info', $this->object->getIcon());

        $this->object->setIcon(new File('error'));
        $this->assertEquals('error', $this->object->getIcon());

        $this->object->setIcon(new File('warning'));
        $this->assertEquals('warning', $this->object->getIcon());
    }

    public function testSetNonStandardIcon(): void
    {
        $this->object->setIcon(new File('informational'));
        $this->assertEquals('informational', $this->object->getIcon());
    }
}
