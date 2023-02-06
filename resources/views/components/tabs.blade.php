@props(['active'])

<div x-data="{
    tabHeadings: [],
    tabStates: [],
    addTab(label) {
        id = this.tabHeadings.indexOf(label);
        if (id < 0) {
            this.tabHeadings.push(label);
            this.tabStates.push(false);
        }
        id = this.tabHeadings.indexOf(label);
        if (label === '{{ $active }}') {
            this.setActiveTab(id);
        }
        return id;
    },
    tabLabel(id) {
        if (typeof this.tabHeadings[id] === 'undefined') {
            return '';
        }
        return this.tabHeadings[id];
    },
    tabState(id) {
        if (typeof this.tabStates[id] === 'undefined') {
            return false;
        }
        return this.tabStates[id];
    },
    setActiveTab(id) {
        this.tabStates.forEach(function(value, index) {
            this[index] = false;
        }, this.tabStates);
        this.tabStates[id] = true;
    }
}">

    <div class="flex overflow-x-auto mb-4 overflow-y-hidden border-b border-gray-200 whitespace-nowrap " role="tablist">
        <template x-for="(state, index) in tabStates" :key="index">
            <button x-text="tabLabel(index)" @click.self="setActiveTab(index)"
                class="inline-flex items-center h-10 px-4 -mb-px text-sm text-center text-gray-700 bg-transparent border-b-2 border-transparent sm:text-base  whitespace-nowrap cursor-base focus:outline-none hover:border-gray-400"
                :class="state === true ? 'text-blue-600 border-blue-500  ' : ''" :id="`tab-${index}`"
                role="tab" :aria-selected="(state === true).toString()"
                :aria-controls="`tab-panel-${index}`"></button>
        </template>
    </div>
    {{ $slot }}
</div>